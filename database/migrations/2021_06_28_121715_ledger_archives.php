<?php


use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LedgerArchives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ledgers', function (Blueprint $table) {
            $table->string('user_agent', 500)->change();
        });

        Schema::connection('audit')->create('ledger_archives', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ledgers', function (Blueprint $table) {
            $table->string('user_agent', 255)->change();
        });

        Schema::connection('audit')->dropIfExists('ledger_archives');
    }
}
