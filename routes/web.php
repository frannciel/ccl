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
*//*
http://www.bosontreinamentos.com.br/mysql/opcoes-de-chave-estrangeira-mysql/
	php artisan route:clear
	php artisan config:clear
	php artisan view:clear
	composer dump-autoload
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

Route::get('contratacao/{licitacao}', 							'ContratacaoController@index')->name('contratacao');
Route::get('contratacao/novo/{licitacao}', 						'ContratacaoController@create');
Route::post('contratacao/update', 								'ContratacaoController@update');
Route::post('contratacao/store', 								'ContratacaoController@store');
Route::get('contratacao/documento/{contratacao}', 				'ContratacaoController@documento');
Route::get('contratacao/pdf/{contratacao}', 					'ContratacaoController@downloadPdf');
Route::delete('contratacao/apagar/{contratacao}', 				'ContratacaoController@destroy');

Route::get('registro/precos/',									'RegistroDePrecoController@index');
Route::get('registro/precos/novo/{licitacao}', 					'RegistroDePrecoController@create');
Route::post('registro/precos/store', 							'RegistroDePrecoController@store');
Route::get('registro/precos/documento/{registroDePreco}', 		'RegistroDePrecoController@documentoCreate');
Route::get('registro/precos/pdf/{registroDePreco}', 			'RegistroDePrecoController@downloadPdf');
Route::delete('registro/precos/apagar/{registroDePreco}', 		'RegistroDePrecoController@destroy');

Route::get('pregao/novo', 										'PregaoController@create')->name('pregaoNovo');
Route::post('pregao/store', 									'PregaoController@store');
Route::post('pregao/update', 									'PregaoController@update');
Route::get('pregao/exibir/{pregao}',							'PregaoController@show')->name('pregaoShow');
Route::get('pregao/item/editar/{uuid}',							'PregaoController@itemEdit');


Route::get('licitacao/atribuir/{licitacao}', 					'LicitacaoController@atribuirShow')->name('licitacaoAtribuirShow');
Route::get('licitacao/item/atribuir/{licitacao}/{requisicao}',  'LicitacaoController@atribuirItemShow')->name('licitacaoAtribuirItemShow');
Route::post('licitacao/item/store/{licitacao}', 				'LicitacaoController@itemStore')->name('licitacaoaItemStore');

//Route::post('licitacao/atribuir/requisicao', 					'LicitacaoController@removerItem')->name('licitacaoRemoverItem');
//Route::post('licitacao/item/remover/{licitacao}', 				'LicitacaoController@removerItem')->name('licitacaoRemoverItem');
//Route::get('licitacao/remover/requisicao/{requisicao}/{licitacao}','LicitacaoController@removerRequisicao');



Route::get('licitacao/', 										'LicitacaoController@index')->name('licitacao');
Route::get('licitacao/novo', 									'LicitacaoController@create')->name('licitacaoNovo');
Route::get('licitacao/exibir/{uuid}',							'LicitacaoController@show')->name('licitacaoShow');
Route::get('licitacao/item/editar/{uuid}',						'LicitacaoController@itemEdit');
Route::get('licitacao/item/mesclar/novo/{uuid}',				'LicitacaoController@mesclarCreate')->name('licitacaoMesclar');
Route::post('licitacao/item/duplicar',							'LicitacaoController@itemDuplicar');
Route::post('licitacao/store', 									'LicitacaoController@store');
Route::post('licitacao/item/mesclar/store',						'LicitacaoController@mesclarStore');
Route::delete('licitacao/apagar/{licitacao}',					'LicitacaoController@destroy')->name('licitacaoDestroy');

Route::get('item/novo/{requisicao_id}', 						'ItemController@create')->name('itemNovo');
Route::get('item/editar/{id}',  								'ItemController@edit')->name('itemEditar');
Route::get('item/fornecedor/novo',								'ItemController@fornecedorCreate')->name('itemFornecNovo');
Route::get('item/fornecedor/exibir/{fornecedor_id}/{item_id}', 	'ItemController@fornecedorShow')->name('itemFornecShow');
Route::post('item/store', 	 									'ItemController@store');
Route::post('item/update', 										'ItemController@update');
Route::post('item/ajax', 										'ItemController@ajax');
Route::post('item/fornecedor/store', 							'ItemController@fornecedorStore');
Route::get('item/fornecedor/update', 							'ItemController@fornecedorUpdate')->name('itemFornecUpdate');
Route::delete('item/apagar/{item}', 							'ItemController@destroy');

Route::post('licitacao/modalidade', 							'LicitacaoController@modalidade')->name('modalidade');
Route::get('cotacao/novo', 										'CotacaoController@redirecionar');
Route::post('item/primeiro', 	 								'ItemController@primeiro');
Route::get('item/segundo', 	 									'ItemController@segundo');
Route::post('cep', 												'FornecedorController@buscarCEP');

Route::get('importar', 											'FileController@create');
Route::get('importar/{uuid}', 									'FileController@create')->name('importar');
Route::post('importar/store', 									'FileController@store')->name('importeSalvar');
Route::post('importar/ata/store', 								'FileController@AtaSrpStore');

Route::get('uasg', 												'UasgController@index')->name('uasg');
Route::get('uasg/novo', 										'UasgController@create')->name('uasg.nova');
Route::get('uasg/editar/{uuid}',  								'UasgController@edit')->name('uasg.editar');
Route::get('uasg/exibir/{uuid}', 								'UasgController@show')->name('uasg.exibir');
Route::post('uasg/store', 	 									'UasgController@store');
Route::post('uasg/update', 										'UasgController@update');

Route::get('requisicao/', 										'RequisicaoController@index')->name('requisicao');
Route::get('requisicao/novo', 									'RequisicaoController@create')->name('requisicaoNova');
Route::get('requisicao/exibir/{requisicao}', 					'RequisicaoController@show')->name('requisicaoShow');
Route::get('requisicao/formalizar/{requisicao}', 				'RequisicaoController@formalizacao')->name('requisicaoFormalizacao');
Route::get('requisicao/formalizar/pdf/{requisicao}', 			'RequisicaoController@formalizacaoPdf');
Route::get('requisicao/pesquisa/{requisicao}', 					'RequisicaoController@pesquisa')->name('requisicaoPesquisa');
Route::get('requisicao/pesquisa/pdf/{requisicao}', 				'RequisicaoController@pesquisaPdf');
Route::get('requisicao/documento/{requisicao}', 				'RequisicaoController@documento')->name('documento');
Route::get('requisicao/consulta/{acao}',						'RequisicaoController@consultar')->name('requisicaoConsulta');
Route::get('requisicao/ata/{id}', 								'RequisicaoController@ataShow')->name('ataShow');
Route::post('requisicao/store', 	 							'RequisicaoController@store');
Route::post('requisicao/update', 								'RequisicaoController@update');
Route::post('requisicao/ajax', 									'RequisicaoController@ajax');
Route::post('requisicao/ata/create', 							'RequisicaoController@ataCreate')->name('ataCreate');
Route::post('requisicao/duplicar/item', 						'RequisicaoController@duplicarItem')->name('requisicaoDuplicarItem');
Route::post('requisicao/remove/item', 							'RequisicaoController@removeItens')->name('requisicaoRemoveItens');
Route::delete('requisicao/apagar/{requisicao}', 				'RequisicaoController@destroy')->name('requisicaoDestroy');

Route::get('fornecedor/', 										'FornecedorController@index')->name('fornecedor');
Route::get('fornecedor/novo/',									'FornecedorController@create')->name('fornecedorNovo');
Route::get('fornecedor/editar/{uuid}',  						'FornecedorController@edit')->name('fornecedorEditar');
Route::get('fornecedor/deleta/{uuid}',  						'FornecedorController@delete')->name('fornecedorApagar');
Route::post('fornecedor/store', 	 							'FornecedorController@store');
Route::post('fornecedor/update', 								'FornecedorController@update');
Route::post('fornecedor/fornecedor', 							'FornecedorController@getFornecedor');

Route::get('cotacao/novo/{requisicao}', 						'CotacaoController@create')->name('cotacaoCreate');
Route::get('cotacao/editar/{cotacao}',  						'CotacaoController@edit')->name('cotacaoEdit');
Route::get('cotacao/relatorio/{requisicao}', 					'CotacaoController@relatorio')->name('cotacaoRelatorio');
Route::get('cotacao/relatorio/pdf/{requisicao}', 				'CotacaoController@relatorioPdf')->name('cotacaoRelatorioPdf');
Route::delete('cotacao/apagar/{cotacao}',  						'CotacaoController@destroy')->name('cotacaoDestroy');
Route::post('cotacao/store', 									'CotacaoController@store')->name('cotacaoStore');
Route::post('cotacao/update', 									'CotacaoController@update')->name('cotacaoUpdate');

Route::get('enquadramento', 			'InformacaoController@index')->name('enquadramento');
Route::get('enquadramento/novo', 		'InformacaoController@create')->name('enquadramentoNovo');
Route::post('enquadramento/dados', 		'InformacaoController@informacao');
Route::post('enquadramento/store', 		'InformacaoController@store');
Route::post('informacao/ajax', 			'InformacaoController@ajax');

/*Route::get('participante/{item_id}',	'ParticipanteController@create')->name('participante');
Route::get('participante/novo/{id}',	'ParticipanteController@create')->name('participanteNovo');
Route::get('participante/editar/{id}',  'ParticipanteController@edit')->name('participanteEditar');
Route::post('participante/store', 	 	'ParticipanteController@store');
Route::post('participante/update', 		'ParticipanteController@update');*/
//Route::get('importar/novo', 									'FileController@redirecionar');
//Route::post('importar/ata/store', 								'FileController@AtaSrpStore');
//Route::get('importar/ata/show', 								'FileController@AtaSrpShow');