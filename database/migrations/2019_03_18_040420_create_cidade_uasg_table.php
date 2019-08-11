<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCidadeUasgTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cidade_uasg', function (Blueprint $table) {
            $table->integer('quantidade');
			$table->integer('cidade_id')->unsigned();
            $table->integer('uasg_id')->unsigned();
			$table->integer('item_id')->unsigned();
            $table->foreign('cidade_id')->references('id')->on('cidades');
			$table->foreign('item_id')->references('id')->on('itens');
            $table->foreign('uasg_id')->references('id')->on('uasgs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cidade_uasg');
    }
}
