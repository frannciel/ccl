<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processos', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('numero', 20)->unique();
            $table->integer('uasg_id')->unsigned();
            $table->integer('licitacao_id')->unsigned();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
            $table->foreign('uasg_id')->references('id')->on('uasgs');
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
        Schema::dropIfExists('processos');
    }
}
