@extends('layouts.index')

@section('content')
	<div id="copiar">
		<h4 align=center>ATA DE REGISTRO DE PREÇOS N.º {{$ata->numero}} / {{$ata->ano}}<br />
		PREGÃO ELETRÔNICO SRP Nº {{$ata->licitacao->numero }} / {{ $ata->licitacao->ano }}<br />
		PROCESSO ADMINISTRATIVO Nº {{$ata->licitacao->processo ?? '23291.000000/20XX-00'}}</h4>
		
		<p align=justify>O INSTITUTO FEDERAL DE EDUCAÇÃO, CIÊNCIA E TECNOLOGIA DA BAHIA – IFBA CAMPUS EUNÁPOLIS, com sede na Avenida David Jonas Fadini, S/n, Rosa Neto, Eunápolis – Bahia. 
		CEP 45823-431, inscrito no CNPJ sob o nº 10.764.307/0010-03, neste ato representado pelo Diretor Geral pro tempore Fabíolo Moraes Amaral, nomeado pela Portaria nº 2.808, de 29 
		de agosto de 2018, publicada no Diário Oficial da União de 30 de agosto de 2018, inscrito no CPF sob o nº 982.829.485-00 portador da Carteira de Identidade nº 08382171-68/SSP/BA, 
		considerando o julgamento da licitação na modalidade de pregão, na forma eletrônica, para REGISTRO DE PREÇOS nº {{$ata->licitacao->numero }} / {{$ata->licitacao->ano}} publicada no D.O.U de {{$ata->licitacao->publicacao ?? 'xx/xx/20xx'}} 
		processo administrativo nº  {{ $ata->licitacao->processo ?? '23291.000000/20XX-00'}}, RESOLVE registrar os preços da(s)  empresa(s) indicada(s) e qualificada(s) nesta ATA, de acordo com a classificação 
		por ela(s) alcançada(s) e na(s)  quantidade(s)  cotada(s), atendendo as condições previstas no edital, sujeitando-se as partes às normas constantes na Lei nº 8.666, de 21 de junho de 1993 
		e suas alterações, no Decreto n.º 7.892, de 23 de janeiro de 2013, e em conformidade com as disposições a seguir:</p>
		<ol>
			<li>1.	DO OBJETO
				<ol>
					<li>A presente Ata tem por objeto o registro de preços para a eventual aquisição de {{$ata->licitacao->objeto ?? ''}} conforme condições, quantidades e exigências estabelecidas no Termo de Referência, anexo I do edital de Pregão nº {{$ata->licitacao->numero}}/{{$ata->licitacao->ano?? 'XXX/XXXX'}} que é parte integrante desta Ata, assim como a proposta vencedora, independentemente de transcrição.</li>
				</ol>
			</li>
			<br />
			<li>DOS PREÇOS, ESPECIFICAÇÕES E QUANTITATIVOS
				<ol>
					<li>O preço registrado, as especificações do objeto, a quantidade, fornecedor(es) e as demais condições ofertadas na(s) proposta(s) são as que seguem: </li>
				</ol>
				<table border=1 width=100% cellspacing=0 cellpadding=2>
					<thead>
						<tr>
							<td colspan=5>
							<b>Fornecedor: {{$ata->fornecedor->nome}}</b><br />
							<b>CPF/CNPJ:</b> {{$ata->fornecedor->cpfCnpj}}	 <br />
							<b>Endereço:</b> {{$ata->fornecedor->endereco}}	 <br />
							<b>CEP:</b> {{$ata->fornecedor->cep}} <br />
							<b>Telefone:</b> {{$ata->fornecedor->telefone_1}} / {{$ata->fornecedor->telefone_2 ?? ''}} <br />
							<b>Email:</b> {{$ata->fornecedor->email}}		 <br />
							<b>Representante Legal:</b> {{$ata->fornecedor->fornecedorable->representante ?? ''}}
							</td>
						</tr>
						<tr bgcolor="#ccc">
							<td align="center" width="5%"> <h4>Item		</h4></td>
							<td align="center" width="55%"> <h4>Especificação		</h4></td>
							<td align="center" width="10%"> <h4>Unidade		</h4></td>
							<td align="center" width="10%"> <h4>Quantidade		</h4></td>
							<td align="center" width="10%"> <h4>Valor Unitário		</h4></td>
						</tr>
					</thead>
					<tbody>
						@foreach($ata->itens->sortBy('ordem') as $item)
						<tr>
							<td align="center">{{$item->ordem}}</td>
							<td align="justify">
								@php
									print($item->descricaoCompleta);
									$marca = $item->fornecedores()->where('fornecedor_id', $ata->fornecedor->id)->first()->pivot->marca;
									$modelo = $item->fornecedores()->where('fornecedor_id', $ata->fornecedor->id)->first()->pivot->modelo;
								@endphp
								@if($marca)	<br><br> Marca: {{$marca}}	@endif
								@if($modelo) - Modelo: {{$modelo}}	@endif
							
							</td>
							<td align="center">{{$item->unidade->nome}}</td>
							<td align="center">{{$item->fornecedores()->where('fornecedor_id', $ata->fornecedor->id)->first()->pivot->quantidade}}</td>
							<td align="center">R$ {{number_format($item->fornecedores()->where('fornecedor_id', $ata->fornecedor->id)->first()->pivot->valor, 4, ',', '.')}}</td>
						</tr>
						@endforeach
						<tr>
							<td align=right colspan=4> TOTAL</td>						
							<td align="center"> R$ {{number_format($total, 2,',', '.' )}}  </td>
						</tr>
					</tbody>
				</table>
			</li>
			<br />							
			<li>ÓRGÃO(S) GERENCIADOR E PARTICIPANTE(S)
				@if ($participantes > 0)
					<ol>
						<li>O órgão gerenciador será o Instituto Federal de Educação, Ciência E Tecnologia da Bahia campus Eunápolis.</li>
						<li>São órgãos e entidades públicas participantes do registro de preços:</li>
					</ol>
					<table border=1 width=100% cellspacing=0 cellpadding=2>
						<thead>
							<tr bgcolor="#ccc">
								<td align="center" width="10%"> Item</td>
								<td align="center" width="70%"> Orgão(s) Participante(s)</td>
								<td align="center" width="20%"> Quantidade</td>
							</tr>
						</thead>
						<tbody>
						@foreach($ata->itens->sortBy('ordem') as $item)
							@forelse ($item->participantes()->get() as $uasg)
							<tr>
								<td align="center">{{$item->ordem}}</td>
								<td>{{$uasg->codigo}} - {{$uasg->nome}}</td>
								<td align="center">{{$item->participantes()->where('uasg_id', $uasg->id)->first()->pivot->quantidade}}</td>
							</tr>
							@empty
							@endforelse
						@endforeach
						</tbody>
					</table>
				@else
					<ol>
						<li>O órgão gerenciador será o Instituto Federal de Educação, Ciência e Tecnologia da Bahia campus Eunápolis.</li>
						<li>Não constam órgãos e entidades públicas participantes do registro de preços.</li>
					</ol>
				@endif
			</li>		
			<br />			
			<li>DA ADESÃO À ATA DE REGISTRO DE PREÇOS 
				<ol>
					<li>A ata de registro de preços, durante sua validade, poderá ser utilizada por qualquer órgão ou entidade da administração pública que não tenha participado do certame licitatório, mediante anuência do órgão gerenciador, desde que devidamente justificada a vantagem e respeitadas, no que couber, as condições e as regras estabelecidas na Lei nº 8.666, de 1993 e no Decreto nº 7.892, de 2013.
						<ol>
							<li>A manifestação do órgão gerenciador de que trata o subitem anterior, salvo para adesões feitas por órgãos ou entidades de outras esferas federativas, fica condicionada à realização de estudo, pelos órgãos e pelas entidades que não participaram do registro de preços, que demonstre o ganho de eficiência, a viabilidade e a economicidade para a administração pública federal da utilização da ata de registro de preços, conforme estabelecido em ato do Secretário de Gestão do Ministério do Planejamento, Desenvolvimento e Gestão</li>
						</ol>
					</li>
					<li>Caberá ao fornecedor beneficiário da Ata de Registro de Preços, observadas as condições nela estabelecidas, optar pela aceitação ou não do fornecimento, desde que este fornecimento não prejudique as obrigações anteriormente assumidas com o órgão gerenciador e órgãos participantes. </li>
					<li>As aquisições ou contratações adicionais a que se refere este item não poderão exceder, por órgão ou entidade, a cinquenta por cento dos quantitativos dos itens do instrumento convocatório e registrados na ata de registro de preços para o órgão gerenciador e órgãos participantes.</li>
					<li>As adesões à ata de registro de preços são limitadas, na totalidade, ao dobro do quantitativo de cada item registrado na ata de registro de preços para o órgão gerenciador e órgãos participantes, independente do número de órgãos não participantes que eventualmente aderirem.
						<ol>
							<li>Tratando-se de item exclusivo para microempresas e empresas de pequeno porte e cooperativas enquadradas no artigo 34 da Lei n° 11.488, de 2007, o órgão gerenciador somente autorizará a adesão caso o valor da contratação pretendida pelo aderente, somado aos valores das contratações já previstas para o órgão gerenciador e participantes ou já destinadas à aderentes anteriores, não ultrapasse o limite de R$ 80.000,00 (oitenta mil reais) (Acórdão TCU nº 2957/2011 – P).</li>
						</ol>
					</li>
					<li>Ao órgão não participante que aderir à ata competem os atos relativos à cobrança do cumprimento pelo fornecedor das obrigações contratualmente assumidas e a aplicação, observada a ampla defesa e o contraditório, de eventuais penalidades decorrentes do descumprimento de cláusulas contratuais, em relação as suas próprias contratações, informando as ocorrências ao órgão gerenciador.</li>
					<li>Após a autorização do órgão gerenciador, o órgão não participante deverá efetivar a contratação solicitada em até noventa dias, observado o prazo de validade da Ata de Registro de Preços.</li>
					<li>Caberá ao órgão gerenciador autorizar, excepcional e justificadamente, a prorrogação do prazo para efetivação da contratação, respeitado o prazo de vigência da ata, desde que solicitada pelo órgão não participante.</li>
				</ol>
			</li>
			<br />
			<li>VALIDADE DA ATA 
				<ol>
					<li>A validade da Ata de Registro de Preços será de 12 meses, a partir da sua assinatura, não podendo ser prorrogada.</li>
				</ol>
			</li>
			<br />
			<li>REVISÃO E CANCELAMENTO 
				<ol>
					<li>A Administração realizará pesquisa de mercado periodicamente, em intervalos não superiores a 180 (cento e oitenta) dias, a fim de verificar a vantajosidade dos preços registrados nesta Ata.</li>
					<li>Os preços registrados poderão ser revistos em decorrência de eventual redução dos preços praticados no mercado ou de fato que eleve o custo do objeto registrado, cabendo à Administração promover as negociações junto ao(s) fornecedor(es).</li>
					<li>Quando o preço registrado tornar-se superior ao preço praticado no mercado por motivo superveniente, a Administração convocará o(s) fornecedor(es) para negociar(em) a redução dos preços aos valores praticados pelo mercado.</li>
					<li>O fornecedor que não aceitar reduzir seu preço ao valor praticado pelo mercado será liberado do compromisso assumido, sem aplicação de penalidade.</li>
					<li>Quando o preço de mercado tornar-se superior aos preços registrados e o fornecedor não puder cumprir o compromisso, o órgão gerenciador poderá:
						<ol>
							<li>liberar o fornecedor do compromisso assumido, caso a comunicação ocorra antes do pedido de fornecimento, e sem aplicação da penalidade se confirmada a veracidade dos motivos e comprovantes apresentados; e</li>
							<li>convocar os demais fornecedores para assegurar igual oportunidade de negociação.</li>
						</ol>
					</li>
					<li>Não havendo êxito nas negociações, o órgão gerenciador deverá proceder à revogação desta ata de registro de preços, adotando as medidas cabíveis para obtenção da contratação mais vantajosa.</li>
					<li>O registro do fornecedor será cancelado quando:
						<ol>
							<li>descumprir as condições da ata de registro de preços;</li>
							<li>não retirar a nota de empenho ou instrumento equivalente no prazo estabelecido pela Administração, sem justificativa aceitável;</li>
							<li>não aceitar reduzir o seu preço registrado, na hipótese deste se tornar superior àqueles praticados no mercado; ou</li>
							<li>sofrer sanção administrativa cujo efeito torne-o proibido de celebrar contrato administrativo, alcançando o órgão gerenciador e órgão(s) participante(s).</li>
						</ol>
					</li>
					<li>O cancelamento de registros nas hipóteses previstas nos itens 6.7.1, 6.7.2 e 6.7.4 será formalizado por despacho do órgão gerenciador, assegurado o contraditório e a ampla defesa.</li>
					<li>O cancelamento do registro de preços poderá ocorrer por fato superveniente, decorrente de caso fortuito ou força maior, que prejudique o cumprimento da ata, devidamente comprovados e justificados:
						<ol>
							<li>por razão de interesse público; ou</li>
							<li>a pedido do fornecedor. </li>
						</ol>
					</li>
				</ol>
			</li>
			<br />
			<li>DAS PENALIDADES
				<ol>
					<li>O descumprimento da Ata de Registro de Preços ensejará aplicação das penalidades estabelecidas no Edital.</li>
					<li>É da competência do órgão gerenciador a aplicação das penalidades decorrentes do descumprimento do pactuado nesta ata de registro de preço (art. 5º, inciso X, do Decreto nº 7.892/2013), exceto nas hipóteses em que o descumprimento disser respeito às contratações dos órgãos participantes, caso no qual caberá ao respectivo órgão participante a aplicação da penalidade (art. 6º, Parágrafo único, do Decreto nº 7.892/2013).</li>
					<li>O órgão participante deverá comunicar ao órgão gerenciador qualquer das ocorrências previstas no art. 20 do Decreto nº 7.892/2013, dada a necessidade de instauração de procedimento para cancelamento do registro do fornecedor.</li>
				</ol>
			</li>
			<br />
			<li>CONDIÇÕES GERAIS
			<ol>
				<li>As condições gerais do fornecimento, tais como os prazos para entrega e recebimento do objeto, as obrigações da Administração e do fornecedor registrado, penalidades e demais condições do ajuste, encontram-se definidos no Termo de Referência, ANEXO AO EDITAL.</li>
				<li>É vedado efetuar acréscimos nos quantitativos fixados nesta ata de registro de preços, inclusive o acréscimo de que trata o § 1º do art. 65 da Lei nº 8.666/93, nos termos do art. 12, §1º do Decreto nº 7892/13.</li>
				<li>No caso de adjudicação por preço global de grupo de itens, só será admitida a contratação dos itens nas seguintes hipóteses.
					<ol>
						<li>contratação da totalidade dos itens de grupo, respeitadas as proporções de quantitativos definidos no certame; ou</li>
						<li>contratação de item isolado para o qual o preço unitário adjudicado ao vencedor seja o menor preço válido ofertado para o mesmo item na fase de lances</li>
					</ol>
				</li>
				<li>A ata de realização da sessão pública do pregão, contendo a relação dos licitantes que aceitarem cotar os bens ou serviços com preços iguais ao do licitante vencedor do certame, será anexada a esta Ata de Registro de Preços, nos termos do art. 11, §4º do Decreto n. 7.892, de 2014.</li>
			</ol>
		</li>
		</ol>
		<p align=justify>Para firmeza e validade do pactuado, a presente Ata foi lavrada em sistema eletrônico de informação, que, depois de lida e achada em ordem, vai assinada pelas partes via sistema eletrônico de informação e encaminhada cópia aos demais órgãos participantes (se houver). </p>
		<center>Eunápolis – BA, {{ $ata->assinatura ?? date("d/m/Y")}}</center>
		<center>Assinaturas</center>
		<center>Representante legal do órgão gerenciador e representante(s) legal(is) do(s) fornecedor(s) registrado(s)</center>
	</div"><!-- conteudo a ser copiado -->

	<div class="row">
		<div class="col-md-6 col-md-offset-3" style="margin-top:20px;">
			<a href="#" class="btn btn-success btn-block" type="button" data-clipboard-action='copy' data-clipboard-target='#copiar'>Copiar</a>
		</div>
	</div>
@endsection
