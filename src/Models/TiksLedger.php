<?php

namespace App\Models;

use Altek\Accountant\Models\Ledger;

class TiksLedger extends Ledger
{
    protected $connection;

    public function __construct(array $attributes = [])
    {
        $connections = config('database.connections');

        $auditExists = array_get($connections, 'audit', false);
        $connection = $auditExists ? 'audit' : 'mysql';

        $this->connection = $connection;

        parent::__construct($attributes);
    }
}
