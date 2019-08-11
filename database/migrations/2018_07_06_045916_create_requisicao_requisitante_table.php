<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicaoRequisitanteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicao_requisitante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('requisicao_id')->unsigned();
            $table->integer('requisitante_id')->unsigned();
            $table->foreign('requisicao_id')->references('id')->on('requisicoes');
            $table->foreign('requisitante_id')->references('id')->on('requisitantes');
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
        Schema::dropIfExists('requisicao_requisitante');
    }
}
