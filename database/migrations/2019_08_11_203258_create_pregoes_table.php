<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePregoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {        
        Schema::create('pregoes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->smallInteger('srp');
            $table->smallInteger('tipo');
            $table->smallInteger('forma');
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
        Schema::dropIfExists('pregoes');
    }
}
