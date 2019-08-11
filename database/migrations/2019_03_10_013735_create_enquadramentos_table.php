<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEnquadramentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enquadramentos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('processo', 20);
            $table->string('numero', 30)->nullable();
            $table->string('objeto', 300);
            $table->string('valor', 20);
            $table->string('classificacao', 3);
            $table->string('normativa', 3);
            $table->string('modalidade', 3)->nullable();
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
        Schema::dropIfExists('enquadramentos');
    }
}
