<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LedgerArchives extends Migration
{

    public $connection;

    public function __construct()
    {
        $connections = config('database.connections');
        $exits = array_get($connections, 'audit', false);
        $this->connection = $exits ? 'audit' : 'mysql';
    }

    public function up()
    {
        Schema::connection($this->connection)->create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_type')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->morphs('recordable');
            $table->unsignedTinyInteger('context');
            $table->string('event');
            $table->text('properties');
            $table->text('modified');
            $table->text('pivot');
            $table->text('extra');
            $table->text('url')->nullable();
            $table->ipAddress('ip_address')->nullable();
            $table->string('user_agent', 500)->nullable();
            $table->string('signature');
            $table->timestamps();

            $table->index([
                'user_id',
                'user_type',
            ]);
        });
    }

    public function down()
    {
        Schema::connection($this->connection)->dropIfExists('ledgers');
    }
}
