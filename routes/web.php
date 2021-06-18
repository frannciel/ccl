<?php
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


Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {
    Auth::routes();
    Route::get('home', 'HomeController@index')->name('home');
    Route::middleware('auth:admin')->group(function () {
     	//Route::get('another', 'AnotherController@index')->name('another');
    });
});

Route::middleware('guest')->group(function(){
	Route::get('/', function () {
	    return view('auth.login');
	});
});

Route::middleware('auth')->group(function(){
	Route::prefix('requisicao')->name('requisicao.')->group(function(){
		Route::get('/', 									'RequisicaoController@index')->name('index');
		Route::get('/novo', 								'RequisicaoController@create')->name('create');
		Route::post('/novo', 	 							'RequisicaoController@store')->name('store');
		Route::get('/exibir/{requisicao}', 					'RequisicaoController@show')->name('show');
		Route::post('/update/{requisicao}', 				'RequisicaoController@update')->name('update');
		Route::get('/formalizar/{requisicao}', 				'RequisicaoController@formalizacao')->name('formalizacao');
		Route::get('/formalizar/pdf/{requisicao}', 			'RequisicaoController@formalizacaoPdf')->name('formalizacaoPdf');
		Route::get('/pesquisa/{requisicao}', 				'RequisicaoController@pesquisa')->name('pesquisa');
		Route::get('/pesquisa/pdf/{requisicao}', 			'RequisicaoController@pesquisaPdf')->name('pesquisaPdf');
		Route::get('/documento/{requisicao}', 				'RequisicaoController@documento')->name('documento');
		Route::get('/consulta/{acao}',						'RequisicaoController@consultar')->name('consulta');
		//Route::get('/ata/{id}', 							'RequisicaoController@ataShow')->name('ataShow');
		Route::get('/importar/{requisicao}', 				'RequisicaoController@importar')->name('importar');
		Route::post('/ajax', 								'RequisicaoController@ajax')->name('ajax');
		Route::post('/ata/create', 							'RequisicaoController@ataCreate')->name('ataCreate');
		Route::post('/duplicar/item', 						'RequisicaoController@duplicarItem')->name('duplicarItem');
		Route::post('/remove/item', 						'RequisicaoController@removeItens')->name('removeItens');
		Route::delete('/apagar/{requisicao}', 				'RequisicaoController@destroy')->name('destroy');
	});

	Route::prefix('item')->name('item.')->group(function(){
		Route::get('/novo/{requisicao}', 							'ItemController@create')->name('create');
		Route::post('/novo/{requisicao}/{novo?}',  					'ItemController@store')->name('store');
		Route::get('/editar/{item}',  								'ItemController@edit')->name('edit');
		Route::post('/editar/{item}',  								'ItemController@update')->name('update');
		Route::delete('/apagar/{item}', 							'ItemController@destroy')->name('destroy');
		Route::get('/licitacao/editar/{item}',						'ItemController@editItemLicitacao')->name('editItemLicitacao');
		Route::get('/fornecedor/novo',								'ItemController@fornecedorCreate')->name('fornecedorCreate');
		Route::get('/fornecedor/exibir/{fornecedor_id}/{item_id}', 	'ItemController@fornecedorShow')->name('fornecedorShow');
		Route::put('/licitacao/update/{item}',						'ItemController@updateItemLicitacao')->name('updateItemLicitacao');
		Route::post('/ajax', 										'ItemController@ajax')->name('ajax');
		Route::post('/fornecedor/store', 							'ItemController@fornecedorStore')->name('fornecedorStore');
		Route::get('/fornecedor/update', 							'ItemController@fornecedorUpdate')->name('fornecedorUpdate');
		Route::post('/importar/texto/{requisicao}', 				'ItemController@importarTexto')->name('importarTexto');
	});

	Route::prefix('cotacao')->name('cotacao.')->group(function(){
		Route::get('/novo/{requisicao}', 					'CotacaoController@create')->name('create');
		Route::post('/novo/{requisicao}', 					'CotacaoController@store')->name('store');
		Route::get('/relatorio/{requisicao}', 				'CotacaoController@relatorio')->name('relatorio');
		Route::get('/relatorio/pdf/{requisicao}', 			'CotacaoController@relatorioPdf')->name('relatorioPdf');
		Route::post('/importar/excel/{requisicao}', 		'CotacaoController@importarExcel')->name('importarExcel');
		Route::post('Cotacao/importar/texto/{requisicao}', 	'CotacaoController@importarTexto')->name('importarTexto');
		Route::delete('/apagar/{cotacao}',  				'CotacaoController@destroy')->name('destroy');
	});
});

Route::middleware(['auth', 'ac'])->group(function(){
	Route::prefix('licitacao')->name('licitacao.')->namespace('Licitacao')->group(function(){
		Route::get('/', 												'LicitacaoController@index')->name('index');
		Route::post('/novo', 											'LicitacaoController@store')->name('store');
		Route::get('/exibir/{licitacao}',								'LicitacaoController@show')->name('show'); 
		Route::delete('/apagar/{licitacao}',							'LicitacaoController@destroy')->name('destroy');
		Route::post('/item/duplicar/{licitacao}',						'LicitacaoController@itemDuplicar')->name('itemDuplicar');
		Route::get('/relacaodeitem/{licitacao}', 						'LicitacaoController@relacaoDeItem')->name('relacaoDeItem');
		Route::get('/relacaodeitem/pdf/{licitacao}', 					'LicitacaoController@relacaoDeItemPdf')->name('relacaoDeItemPdf');
		Route::get('/importar/{licitacao}', 							'LicitacaoController@importar')->name('importar');

		Route::get('/atribuir/ítem/{licitacao}/{requisicao?}', 			'AtribuirController@create')->name('atribuir.create');
		Route::post('/atribuir/item/{licitacao}', 						'AtribuirController@store')->name('atribuir.store');
		Route::post('/remover/item/{licitacao}', 						'AtribuirController@remove')->name('atribuir.remove'); 
		Route::delete('/remover/requisicao/{licitacao}/{requisicao}',	'AtribuirController@removerRequisicao')->name('requisicao.remove');
	//  Route::post('/atribuir/requisicao/{licitacao}/{requisicao}', 	'AtribuirController@atribuirRequisicao')->name('requisicao.atribuir'); // metodo não utilizado, verificar necesssidade

		Route::get('/item/mesclar/novo/{licitacao}',					'MesclarItemController@create')->name('mesclar.create');
		Route::post('/item/mesclar/novo',								'MesclarItemController@store')->name('mesclar.store');
		Route::delete('/item/separar/{item}',							'MesclarItemController@separar')->name('mesclar.separar');
	});

	Route::prefix('pregao')->name('pregao.')->group(function(){
		Route::get('/novo', 						'PregaoController@create')->name('create');
		Route::post('/novo', 						'PregaoController@store')->name('store');
		Route::post('/update', 						'PregaoController@update')->name('update');
		Route::get('/exibir/{pregao}',				'PregaoController@show')->name('show');
		Route::get('/item/editar/{uuid}',			'PregaoController@itemEdit')->name('itemEdit');
	});

	Route::prefix('registro/precos')->name('registroDePreco.')->group(function(){
		Route::get('/',									'RegistroDePrecoController@index');
		Route::get('/novo/{licitacao}', 				'RegistroDePrecoController@create');
		Route::post('/store', 							'RegistroDePrecoController@store');
		Route::get('/documento/{registroDePreco}', 		'RegistroDePrecoController@documentoCreate');
		Route::get('/pdf/{registroDePreco}', 			'RegistroDePrecoController@downloadPdf');
		Route::delete('/apagar/{registroDePreco}', 		'RegistroDePrecoController@destroy');
	});

	Route::prefix('contratacao')->name('contratacao.')->group(function(){
		Route::get('/{licitacao}', 					'ContratacaoController@index')->name('index');
		Route::get('/novo/{licitacao}', 			'ContratacaoController@create')->name('create');
		Route::post('/update', 						'ContratacaoController@update')->name('update');
		Route::post('/store', 						'ContratacaoController@store')->name('store');
		Route::get('/documento/{contratacao}', 		'ContratacaoController@documento')->name('documento');
		Route::get('/pdf/{contratacao}', 			'ContratacaoController@downloadPdf')->name('downloadPdf');
		Route::delete('/apagar/{contratacao}', 		'ContratacaoController@destroy')->name('destroy');
	});

	Route::prefix('fornecedor')->name('fornecedor.')->group(function(){
		Route::get('/', 							'FornecedorController@index')->name('index');
		Route::get('/novo',							'FornecedorController@create')->name('create');
		Route::post('/novo', 	 					'FornecedorController@store')->name('store');
		Route::get('/editar/{fornecedor}', 		 	'FornecedorController@edit')->name('edit');
		Route::post('/editar', 						'FornecedorController@update')->name('update');
		Route::post('/fornecedor', 					'FornecedorController@getFornecedor')->name('getFornecedor');
		Route::delete('/apagar/{fornecedor}', 		'FornecedorController@destroy')->name('destroy');
	});
});

Route::get('atribuir', function () {
    return view('item.atribuir');
});

Route::post('licitacao/modalidade', 							'LicitacaoController@modalidade')->name('modalidade');
Route::get('cotacao/novo', 										'CotacaoController@redirecionar');
Route::post('item/primeiro', 	 								'ItemController@primeiro');
Route::get('item/segundo', 	 									'ItemController@segundo');
Route::post('cep', 												'FornecedorController@buscarCEP');

Route::get('uasg', 												'UasgController@index')->name('uasg');
Route::get('uasg/novo', 										'UasgController@create')->name('uasg.nova');
Route::get('uasg/editar/{uuid}',  								'UasgController@edit')->name('uasg.editar');
Route::get('uasg/exibir/{uuid}', 								'UasgController@show')->name('uasg.exibir');
Route::post('uasg/store', 	 									'UasgController@store');
Route::post('uasg/update', 										'UasgController@update');

Route::get('enquadramento', 			'InformacaoController@index')->name('enquadramento');
Route::get('enquadramento/novo', 		'InformacaoController@create')->name('enquadramentoNovo');
Route::post('enquadramento/dados', 		'InformacaoController@informacao');
Route::post('enquadramento/store', 		'InformacaoController@store');
Route::post('informacao/ajax', 			'InformacaoController@ajax');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('.home');

//Route::get('importar', 											'ImporteTextoController@create');
//Route::get('importar/{uuid}', 									'ImporteTextoController@create')->name('importar');
//Route::post('importar/store', 									'ImporteTextoController@store')->name('importeSalvar');
//Route::post('importar/ata/store', 								'ImporteTextoController@AtaSrpStore');
//Route::post('importar/arquivo/{licitacao}', 					 	'ImporteTextoController@importarIrp')->name('fileImportarIrp');

// Route::get('fornecedor/importar/', 								'ImporteTextoController@fornecedorCreate')->name('importeText.fornecedorCreate');
// Route::get('licitacao/importar/{licitacao}', 					'ImporteTextoController@licitacaoCreate')->name('importeText.licitacaoCreate');
// Route::post('fornecedor/importar/texto', 						'ImporteTextoController@fornecedor')->name('importeText.fornecedor');
// Route::post('participante/importar/texto/{licitacao}', 			'ImporteTextoController@licitacao')->name('importeText.participante');
// Route::post('registroDePreco/importar/texto/{licitacao}', 		'ImporteTextoController@licitacao')->name('importeText.registroDePreco');
// Route::post('fornecedor/importar/excel', 						'ImporteExcelController@fornecedor')->name('importExcel.fornecedor');
// Route::post('participante/importar/excel/{licitacao}', 			'ImporteExcelController@participante')->name('importExcel.participante');
// Route::get('fornecedor/importar/excel', 							'ImporteExcelController@fornecedorCreate')->name('importExcel.fornecedor');
// Route::get('participante/importar/excel/{licitacao}', 			'ImporteExcelController@licitacaoCreate')->name('importExcel.participante');

/*Route::get('participante/{item_id}',	'ParticipanteController@create')->name('participante');
Route::get('participante/novo/{id}',	'ParticipanteController@create')->name('participanteNovo');
Route::get('participante/editar/{id}',  'ParticipanteController@edit')->name('participanteEditar');
Route::post('participante/store', 	 	'ParticipanteController@store');
Route::post('participante/update', 		'ParticipanteController@update');*/
//Route::get('importar/novo', 			'FileController@redirecionar');
//Route::post('importar/ata/store', 	'FileController@AtaSrpStore');
//Route::get('importar/ata/show', 		'FileController@AtaSrpShow');