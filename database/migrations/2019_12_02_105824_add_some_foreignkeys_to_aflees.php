<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSomeForeignkeysToAflees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aflees', function(Blueprint $table)
        {
            $table->integer('transport_fee_id')->unsigned()->nullable();
            $table->foreign('transport_fee_id')->references('id')->on('transport_fees')->onDelete('cascade');
            $table->integer('sibling_id')->unsigned()->nullable();
            $table->foreign('sibling_id')->references('id')->on('aflees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aflees', function(Blueprint $table)
        {
            $table->dropForeign(['transport_fee_id']);
            $table->dropColumn('transport_fee_id');
            $table->dropForeign(['sibling_id']);
            $table->dropColumn('sibling_id');
        });
    }
}
