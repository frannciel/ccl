<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('itens', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->smallInteger('numero');
            $table->integer('quantidade');
            $table->integer('codigo')->nullable();
            $table->string('objeto', 300)->nullable();
            $table->text('descricao');
            $table->integer('ordem')->nullable();
            $table->integer('requisicao_id')->unsigned()->nullable();
            $table->integer('unidade_id')->unsigned();
            $table->integer('licitacao_id')->unsigned()->nullable();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes')->onDelete('set null');
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('requisicao_id')->references('id')->on('requisicoes')->onDelete('cascade');
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
        Schema::dropIfExists('itens');
    }
}
