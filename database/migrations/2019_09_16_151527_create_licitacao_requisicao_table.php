<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicitacaoRequisicaoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitacao_requisicao', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('licitacao_id')->unsigned();
            $table->integer('requisicao_id')->unsigned();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
            $table->foreign('requisicao_id')->references('id')->on('requisicoes');
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
        Schema::dropIfExists('licitacao_requisicao');
    }
}
