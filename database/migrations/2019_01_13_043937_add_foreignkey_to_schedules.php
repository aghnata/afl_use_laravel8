<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignkeyToSchedules extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('schedules', function(Blueprint $table)
        {
            $table->integer('transport_fee_id')->unsigned()->nullable();
            $table->foreign('transport_fee_id')->references('id')->on('transport_fees')->onDelete('cascade');
            $table->integer('afler_id')->unsigned()->nullable();
            $table->foreign('afler_id')->references('id')->on('aflers')->onDelete('cascade');
            $table->integer('aflee_id')->unsigned()->nullable();
            $table->foreign('aflee_id')->references('id')->on('aflees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('schedules', function(Blueprint $table)
        {
            $table->dropForeign(['transport_fee_id']);
            $table->dropColumn('transport_fee_id');
            $table->dropForeign(['afler_id']);
            $table->dropColumn('afler_id');
            $table->dropForeign(['aflee_id']);
            $table->dropColumn('aflee_id');
        });
    }
}
