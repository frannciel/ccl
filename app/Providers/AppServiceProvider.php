<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::morphMap([
            'Pregão Eletrônico' => 'App\Pregao', 
            'Pessoa Física' => 'App\PessoaFisica', 
            'Pessoa Jurídica' => 'App\PessoaJuridica' 
        ]);
        Schema::defaultStringLength(191); // define o tamanho padrão da string
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
