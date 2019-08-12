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
            $table->boolean('srp');
            $table->integer('licitacao_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->integer('forma_id')->default(60)->unsigned();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
            $table->foreign('tipo_id')->references('id')->on('informacoes');
            $table->foreign('forma_id')->references('id')->on('informacoes');
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
