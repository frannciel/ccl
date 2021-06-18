<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name', 60);
            $table->string('email', 60)->unique();
            $table->string('password');
            $table->string('cargo', 80);
            $table->integer('matricula')->nullable();
            $table->string('telefone', 12)->unique();
            $table->boolean('isAc')->nullable();
            $table->integer('requisitante_id')->unsigned();
            $table->foreign('requisitante_id')->references('id')->on('requisitantes')->onDelete('cascade');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
