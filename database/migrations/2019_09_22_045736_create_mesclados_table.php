<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMescladosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mesclados', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mesclado_id')->unsigned();
            $table->integer('item_id')->unsigned();
            $table->integer('licitacao_id')->unsigned();
            $table->foreign('mesclado_id')->references('id')->on('itens');
            $table->foreign('item_id')->references('id')->on('itens');
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
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
        Schema::dropIfExists('mesclados');
    }
}
