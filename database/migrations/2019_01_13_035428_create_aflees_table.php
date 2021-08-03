<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfleesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aflees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('aflee_name')->nullable();
            $table->string('aflee_address')->nullable();
            $table->string('parent_name')->nullable();            
            $table->string('parent_wa_number')->nullable();
            $table->string('wa_number')->nullable();
            $table->string('id_line')->nullable();
            $table->string('school_name')->nullable();
            $table->string('schedule_plan')->nullable();
            $table->integer('cost')->nullable();
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
        Schema::dropIfExists('aflees');
    }
}
