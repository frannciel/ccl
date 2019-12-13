<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('endereco', 300)->nullable();
            $table->string('cep', 10)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefone_1', 20)->nullable();
            $table->string('telefone_2', 20)->nullable();
            $table->integer('fornecedorable_id')->unsigned();
            $table->string('fornecedorable_type', 100);
            $table->integer('cidade_id')->nullable()->unsigned();
            $table->foreign('cidade_id')->references('id')->on('cidades');
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
        Schema::dropIfExists('fornecedores');
    }
}
