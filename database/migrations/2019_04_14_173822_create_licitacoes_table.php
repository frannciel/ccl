<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLicitacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licitacoes', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->smallInteger('numero');
            $table->smallInteger('ano');
            $table->string('objeto', 200);
            $table->string('processo', 20);
            $table->integer('modalidade_id')->unsigned();
            $table->integer('classificacao_id')->unsigned();
            $table->integer('tipo_id')->unsigned();
            $table->integer('forma_id')->default(60)->unsigned();
            $table->unique(['numero', 'ano']);
            $table->foreign('classificacao_id')->references('id')->on('informacoes');
            $table->foreign('tipo_id')->references('id')->on('informacoes');
            $table->foreign('forma_id')->references('id')->on('informacoes');
            $table->foreign('modalidade_id')->references('id')->on('informacoes');
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
        Schema::dropIfExists('licitacoes');
    }
}
