<?php
use Illuminate\Http\Request;
use App\Licitacao;
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


Route::get('atribuir', function () {
    return view('item.atribuir');
});



Route::get('pregao/novo', 										'PregaoController@create')->name('pregaoNovo');
Route::post('pregao/store', 									'PregaoController@store');
Route::post('pregao/update', 									'PregaoController@update');
Route::get('pregao/exibir/{uuid}',								'PregaoController@show')->name('pregaoExibir');
Route::get('pregao/item/editar/{uuid}',							'PregaoController@itemEdit');

Route::post('licitacao/item/duplicar',							'LicitacaoController@itemDuplicar');
Route::get('licitacao/', 										'LicitacaoController@index')->name('licitacao');
Route::get('licitacao/novo', 									'LicitacaoController@create')->name('licitacaoNovo');
Route::get('licitacao/exibir/{uuid}',							'LicitacaoController@show')->name('licitacaoExibir');
Route::post('licitacao/store', 									'LicitacaoController@store');
Route::post('licitacao/atribuir/requisicao', 					'LicitacaoController@atribuirRequisicao');
Route::post('licitacao/atribuir/item', 							'LicitacaoController@atribuirItem');
Route::get('licitacao/item/mesclar/novo/{uuid}',				'LicitacaoController@mesclarCreate')->name('licitacaoMesclar');
Route::post('licitacao/item/mesclar/store',						'LicitacaoController@mesclarStore');
Route::get('licitacao/item/editar/{uuid}',						'LicitacaoController@itemEdit');
Route::get('licitacao/remover/requisicao/{requisicao}/{licitacao}',		'LicitacaoController@removerRequisicao');


Route::get('item/novo/{requisicao_id}', 						'ItemController@create')->name('itemNovo');
Route::get('item/editar/{id}',  								'ItemController@edit')->name('itemEditar');
Route::get('item/fornecedor/novo',								'ItemController@fornecedorCreate')->name('itemFornecNovo');
Route::get('item/fornecedor/exibir/{fornecedor_id}/{item_id}', 	'ItemController@fornecedorShow')->name('itemFornecShow');
Route::post('item/store', 	 									'ItemController@store');
Route::post('item/update', 										'ItemController@update');
Route::post('item/ajax', 										'ItemController@ajax');
Route::post('item/fornecedor/store', 							'ItemController@fornecedorStore');
Route::get('item/fornecedor/update', 							'ItemController@fornecedorUpdate')->name('itemFornecUpdate');



Route::post('licitacao/modalidade', 							'LicitacaoController@modalidade')->name('modalidade');
Route::get('cotacao/novo', 										'CotacaoController@redirecionar');
Route::post('item/primeiro', 	 								'ItemController@primeiro');
Route::get('item/segundo', 	 									'ItemController@segundo');
Route::post('cep', 												'FornecedorController@buscarCEP');

//Route::get('importar/novo', 									'FileController@redirecionar');
//Route::post('importar/ata/store', 								'FileController@AtaSrpStore');
//Route::get('importar/ata/show', 								'FileController@AtaSrpShow');
Route::get('requisicao/ata/{id}', 								'RequisicaoController@ataShow')->name('ataShow');
Route::post('requisicao/ata/create', 							'RequisicaoController@ataCreate')->name('ataCreate');



Route::get('importar', 											'FileController@create');
Route::get('importar/{uuid}', 									'FileController@create')->name('importar');
Route::post('importar/store', 									'FileController@store')->name('importeSalvar');
Route::post('importar/ata/store', 								'FileController@AtaSrpStore');



Route::get('registro/precos/documento/{uuid}', 					'RegistroDePrecoController@documentoCreate');
Route::get('registro/precos/novo/{uuid}', 						'RegistroDePrecoController@create');
Route::post('registro/precos/store', 							'RegistroDePrecoController@store');


Route::get('uasg', 												'UasgController@index')->name('uasg');
Route::get('uasg/novo', 										'UasgController@create')->name('uasg.nova');
Route::get('uasg/editar/{uuid}',  								'UasgController@edit')->name('uasg.editar');
Route::get('uasg/exibir/{uuid}', 								'UasgController@show')->name('uasg.exibir');
Route::post('uasg/store', 	 									'UasgController@store');
Route::post('uasg/update', 										'UasgController@update');

Route::get('requisicao/', 				'RequisicaoController@index')->name('requisicao');
Route::get('requisicao/novo', 			'RequisicaoController@create')->name('requisicaoNova');
Route::get('requisicao/exibir/{uuid}', 	'RequisicaoController@show')->name('requisicaoExibir');
Route::get('requisicao/documento/{id}', 'RequisicaoController@documento')->name('documento');
Route::post('requisicao/store', 	 	'RequisicaoController@store');
Route::post('requisicao/update', 		'RequisicaoController@update');
Route::post('requisicao/ajax', 			'RequisicaoController@ajax');
Route::get('requisicao/consulta/{acao}','RequisicaoController@consultar')->name('requisicaoConsulta');
Route::get('requisicao/apagar/{uuid}', 	'RequisicaoController@destroy');

Route::get('fornecedor/', 				'FornecedorController@index')->name('fornecedor');
Route::get('fornecedor/novo/',			'FornecedorController@create')->name('fornecedorNovo');
Route::get('fornecedor/editar/{uuid}',  'FornecedorController@edit')->name('fornecedorEditar');
Route::get('fornecedor/deleta/{uuid}',  'FornecedorController@delete')->name('fornecedorApagar');
Route::post('fornecedor/store', 	 	'FornecedorController@store');
Route::post('fornecedor/update', 		'FornecedorController@update');
Route::post('fornecedor/fornecedor', 	'FornecedorController@getFornecedor');

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

Route::get('enquadramento', 			'InformacaoController@index')->name('enquadramento');
Route::get('enquadramento/novo', 		'InformacaoController@create')->name('enquadramentoNovo');
Route::post('enquadramento/dados', 		'InformacaoController@informacao');
Route::post('enquadramento/store', 		'InformacaoController@store');
Route::post('informacao/ajax', 			'InformacaoController@ajax');