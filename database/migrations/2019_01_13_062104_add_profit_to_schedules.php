<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfitToSchedules extends Migration
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
            $table->integer('profit')->unsigned()->nullable();
            $table->integer('sum_student')->unsigned()->nullable();
            $table->integer('sum_session')->unsigned()->nullable();
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
            $table->dropColumn('profit');
            $table->dropColumn('sum_student');
            $table->dropColumn('sum_session');
        });
    }
}
