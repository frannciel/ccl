<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequisicoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->mediumInteger('numero');
            $table->smallInteger('ano');
            $table->tinyInteger('tipo');
            $table->tinyInteger('prioridade');
            $table->tinyInteger('renovacao');
            $table->tinyInteger('capacitacao');
            $table->tinyInteger('pac');
            $table->date('previsao')->nullable();
            $table->string('metas', 150)->nullable();
            $table->string('descricao', 150);
            $table->text('justificativa');
            $table->integer('requisitante_id')->unsigned();
            $table->foreign('requisitante_id')->references('id')->on('requisitantes');
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
        Schema::dropIfExists('requisicoes');
    }
}
