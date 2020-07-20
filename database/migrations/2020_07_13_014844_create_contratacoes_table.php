<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('contrato')->nullable();
            $table->string('observacao')->nullable();
            $table->integer('fornecedor_id')->unsigned();
            $table->integer('licitacao_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('contratacoes');
    }
}
