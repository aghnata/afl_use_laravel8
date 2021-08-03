<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAflersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aflers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('afler_name')->nullable();
            $table->string('available_status')->nullable();
            $table->string('afler_address')->nullable();
            $table->integer('fee')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aflers');
    }
}
