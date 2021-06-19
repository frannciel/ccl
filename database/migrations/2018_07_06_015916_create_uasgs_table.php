<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUasgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uasgs', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('nome', 200);
            $table->string('telefone', 15)->nullable();
            $table->string('email', 50)->nullable();
            $table->integer('codigo')->unique();
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
        Schema::dropIfExists('uasgs');
    }
}
