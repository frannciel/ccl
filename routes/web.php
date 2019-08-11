<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('principal');
})->name('principal');

Route::get('cotacao/novo', 'CotacaoController@redirecionar');
Route::get('importar/novo', 'FileController@redirecionar');

Route::get('item/novo/{requisicao_id}', 'ItemController@create')->name('itemNovo');
Route::get('item/editar/{id}',  		'ItemController@edit')->name('itemEditar');
Route::get('item/fornecedor/novo',		'ItemController@fornecedorCreate')->name('itemFornecNovo');
Route::get('item/fornecedor/exibir/{fornecedor_id}/{item_id}', 	'ItemController@fornecedorShow')->name('itemFornecShow');
Route::post('item/store', 	 			'ItemController@store');
Route::post('item/update', 				'ItemController@update');
Route::post('item/ajax', 				'ItemController@ajax');
Route::post('item/fornecedor/store', 	'ItemController@fornecedorStore');
Route::post('item/fornecedor/update', 	'ItemController@fornecedorUpdate')->name('itemFornecUpdate');

Route::get('requisicao/ata/{id}', 		'RequisicaoController@ataShow')->name('ataShow');
Route::post('requisicao/ata/create', 	'RequisicaoController@ataCreate')->name('ataCreate');


Route::get('requisicao/', 				'RequisicaoController@index')->name('requisicao');
Route::get('requisicao/novo', 			'RequisicaoController@create')->name('requisicaoNova');
Route::get('requisicao/exibir/{id}', 	'RequisicaoController@show')->name('requisicaoExibir');
Route::get('requisicao/documento/{id}', 'RequisicaoController@documento')->name('documento');
Route::post('requisicao/store', 	 	'RequisicaoController@store');
Route::post('requisicao/update', 		'RequisicaoController@update');
Route::post('requisicao/ajax', 			'RequisicaoController@ajax');
Route::get('requisicao/consulta/{acao}', 'RequisicaoController@consultar')->name('requisicaoConsulta');

Route::get('fornecedor/', 				'FornecedorController@index')->name('fornecedor');
Route::get('fornecedor/novo/',			'FornecedorController@create')->name('fornecedorNovo');
Route::get('fornecedor/editar/{id}',  	'FornecedorController@edit')->name('fornecedorEditar');
Route::get('fornecedor/deleta/{id}',  	'FornecedorController@delete')->name('fornecedorApagar');
Route::post('fornecedor/store', 	 	'FornecedorController@store');
Route::post('fornecedor/update', 		'FornecedorController@update');
Route::post('fornecedor/ajax', 			'FornecedorController@ajax');

Route::get('participante/{item_id}',	'ParticipanteController@create')->name('participante');
Route::get('participante/novo/{id}',	'ParticipanteController@create')->name('participanteNovo');
Route::get('participante/editar/{id}',  'ParticipanteController@edit')->name('participanteEditar');
Route::post('participante/store', 	 	'ParticipanteController@store');
Route::post('participante/update', 		'ParticipanteController@update');

Route::get('cotacao/novo/{requisicao_id}', 		'CotacaoController@create')->name('cotacaoNovo');
Route::get('cotacao/editar/{id}',  		   		'CotacaoController@edit')->name('cotacaoEditar');
Route::get('cotacao/relatorio/{requisicao_id}', 'CotacaoController@relatorio')->name('cotacaoRelatorio');
Route::get('cotacao/apagar/{id}',  		   		'CotacaoController@destroy')->name('cotacaoApagar');
Route::post('cotacao/store', 			   		'CotacaoController@store');
Route::post('cotacao/update', 			   		'CotacaoController@update');

Route::get('importar/novo/{requisicao_id}', 'FileController@create')->name('importarNovo');
Route::post('importar/store', 				'FileController@store')->name('importeSalvar');

Route::get('enquadramento', 			'InformacaoController@index')->name('enquadramento');
Route::get('enquadramento/novo', 		'InformacaoController@create')->name('enquadramentoNovo');
Route::post('enquadramento/dados', 		'InformacaoController@informacao');
Route::post('enquadramento/store', 		'InformacaoController@store');
Route::post('informacao/ajax', 			'InformacaoController@ajax');