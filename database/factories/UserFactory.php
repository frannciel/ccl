<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' 			=> $faker->name,
        'email' 		=> $faker->unique()->safeEmail,
        'password' 		=> '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'cargo' 		=> $faker->jobTitle,
		'matricula' 	=> $faker->numberBetween($min = 1000000, $max = 9999999),
		'telefone' 		=> preg_replace('/[^0-9]/', '', $faker->tollFreePhoneNumber),
		'isAc' 			=> $faker->boolean,
        'requisitante_id'=> App\Requisitante::pluck('id')->random(),
        'remember_token' => str_random(10),
    ];
});
