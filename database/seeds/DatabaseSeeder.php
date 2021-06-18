<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);

    	DB::table('users')->insert([
            'uuid' => '2820bcc0-8056-4010-89fa-817138f28413',
    		'name' => 'Anderson Franciel de Castro',
    		'email' => 'anderson@ifba.edu.br',
	        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
	        'cargo' => 'Asistente em Administracão',
    		'matricula' => '1236547',
    		'telefone' => '79981705451',
    		'isAc' => true,
            'requisitante_id' =>  App\Requisitante::pluck('id')->random(),
	        'remember_token' => str_random(10),
	    ]);

        DB::table('admins')->insert([
            'uuid' => 'c093870c-f629-4f30-9a20-c365f705889a',
            'name' => 'Anderson Franciel de Castro',
            'email' => 'anderson@ifba.edu.br',
            'password' => Hash::make('password'),
            'cargo' => 'Asistente em Administracão',
            'matricula' => '1236547',
            'telefone' => '79981705451',
            'remember_token' => str_random(10),
        ]);
    }
}