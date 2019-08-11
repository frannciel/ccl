<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedorItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedor_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->integer('fornecedor_id')->unsigned();
            $table->integer('quantidade')->nullable();
            $table->double('valor', 9, 4)->nullable();
            $table->string('marca', 50)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->foreign('item_id')->references('id')->on('itens');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores');
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
        Schema::dropIfExists('fornecedor_item');
    }
}
