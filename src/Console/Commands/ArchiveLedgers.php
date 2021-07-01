<?php

namespace Tnchalise\Tiks\Console\Commands;

use Illuminate\Console\Command;
use Tnchalise\Tiks\Services\ArchiveService;

class ArchiveLedgers extends Command
{
    protected $signature = 'archive:ledgers';
    protected $description = 'Archive & delete old ledgers to another DB';

    public function handle()
    {
        $service = app()->make(ArchiveService::class);
        // $service->writeAndWipe();, do nothing
    }
}
