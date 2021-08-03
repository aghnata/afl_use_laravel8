<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFeeCostPerSessionToSchedules extends Migration
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
            $table->integer('fee_per_session')->unsigned()->nullable();
            $table->integer('cost_per_session')->unsigned()->nullable();
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
            $table->dropColumn('fee_per_session');
            $table->dropColumn('cost_per_session');
        });
    }
}
