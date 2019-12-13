<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddItemForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('itens', function (Blueprint $table) {
            $table->integer('licitacao_id')->unsigned()->nullable();
            $table->integer('ordem')->nullable();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes');
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
            $table->dropColumn(['licitacao_id', 'ordem']);
            $table->dropForeign('itens_unidade_id_foreign');
        });
    }
}
