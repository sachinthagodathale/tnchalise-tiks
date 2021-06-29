<?php

namespace Tnchalise\Tiks\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ArchiveService
{

    private $connection;
    private $archiveConnection;
    private $interval;

    public function __construct()
    {
        $this->connection        = DB::connection('mysql');
        $this->archiveConnection = DB::connection('audit');
        $this->interval          = config('ledger-archive.interval', 3);
    }


    public function writeAndWipe()
    {
        $exists = $this->archiveConnection->table('ledger_archives')->orderBy('id', 'DESC')->first();
        $filter = $exists ? $exists->created_at : Carbon::createFromDate(2021, 1, 1);

        $this->connection->beginTransaction();
        $this->archiveConnection->beginTransaction();

        try {
            $archiveDate    = Carbon::now()->subMonths($this->interval);
            $totalInsertion = $this->connection->table('ledgers')->where('created_at', '>', $filter)->count();
            $toDelete       = $this->connection->table('ledgers')->where('created_at', '<=', $archiveDate);
            $totalDeletion  = $toDelete->count();

            $this->connection->table('ledgers')->where('created_at', '>', $filter)->orderBy('id')->chunk(1000, function ($chunks) {
                $insert = [];
                foreach ($chunks as $chunk) {
                    $insert[] = collect($chunk)->except('id')->toArray();
                }

                $this->archiveConnection->table('ledger_archives')->insert($insert);
            });

            $toDelete->delete();
            $this->connection->statement('ALTER TABLE ledgers AUTO_INCREMENT=1');

            $logger = sprintf(
                "Ledger Synced:- %s rows, Total Deletion:- %s rows",
                $totalInsertion,
                $totalDeletion
            );

            info($logger);

            $this->connection->commit();
            $this->archiveConnection->commit();

        } catch (\Exception $e) {
            $this->connection->rollBack();
            $this->archiveConnection->rollBack();

            throw new $e;
        }
    }
}
