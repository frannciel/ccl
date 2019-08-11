<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemForeignkey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens', function (Blueprint $table) {
            $table->foreign('unidade_id')->references('id')->on('unidades');
            $table->foreign('requisicao_id')->references('id')->on('requisicoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('itens', function (Blueprint $table) {
            $table->dropForeign('itens_unidade_id_foreign');
            $table->dropForeign('itens_requisicao_id_foreign');
        });
    }
}
