<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistroDePrecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registro_precos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->smallInteger('numero');
            $table->smallInteger('ano');
            $table->date('assinatura');
            $table->date('vigencia_inicio');
            $table->date('vigencia_fim');
            $table->integer('fornecedor_id')->unsigned();
            $table->integer('licitacao_id')->unsigned();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
            $table->unique(['numero', 'ano']);
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
        Schema::dropIfExists('registro_precos');
    }
}
