<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContratacaoItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contratacao_item', function (Blueprint $table) {
            $table->integer('quantidade');
            $table->double('valor', 9, 4);
            $table->integer('item_id')->unsigned();
            $table->integer('contratacao_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('itens');
            $table->foreign('contratacao_id')->references('id')->on('contratacoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contratacao_item');
    }
}
