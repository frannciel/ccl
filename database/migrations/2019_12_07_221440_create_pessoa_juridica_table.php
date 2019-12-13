<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePessoaJuridicaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pessoas_juridicas', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('cnpj', 18)->unique();
            $table->string('razao_social', 200);
            $table->string('representante', 100)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pessoas_juridicas');
    }
}
