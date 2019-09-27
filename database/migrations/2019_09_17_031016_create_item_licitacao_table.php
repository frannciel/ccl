<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemLicitacaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_licitacao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ordem');
            $table->integer('item_id')->unsigned();
            $table->integer('licitacao_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('itens');
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_licitacao');
    }
}
