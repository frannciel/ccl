@extends('site.layouts.index')

@section('content')
   <div class="panel panel-default">

      <div class="panel-heading">
         <div class="row">
            <div class="col-md-12">
               <h1 class="center">Solicitações de Empenho</h1>
            </div><!-- / col-md-3 -->
         </div><!-- / row -->

         <div class="alert alert-default" role="alert">
            <h3>
               <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
               <a href="{{url('licitacao/exibir', $licitacao->uuid)}}">Licitacão n° {{$licitacao->ordem ?? ''}}</a>
            </h3>
            <p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
         </div> 
      </div><!-- / panel-body -->

      <div class="panel-body" >

         <div class="row mt-2 mb-2 row-fluid">
            <div class="col-md-3  col-md-offset-6 col-12">
               <button id="btnTudo" data-clicked="0"   class="btn btn-primary btn-block"  type="button">Incluir Tudo</button>
            </div><!-- / col-md-3 -->

            @include('form.text', [
            'input' => 'total',
            'label' => 'TOTAL GERAL:',
            'value' => old($input ?? ''),
            'largura' => 3, 
            'attributes' => ['id' => 'total', 'disabled' =>""]])
         </div><!-- / row -->

         <div class="row">
            <div class="col-md-12">
               @if (count($dados) > 0)
                  <div class="table-responsive div-tabela">
                     <table class="table table-striped table-tabela">
                        <thead>
                           <tr>
                              <th class="center th-tabela">Item</th>
                              <th class="center th-tabela w-3">Descrição</th>
                              <th class="center th-tabela">Unidade</th>
                              <th class="center th-tabela">Empenhado</th>
                              <th class="center th-tabela">Saldo</th>
                              <th class="center th-tabela">Valor Unitário</th>
                              <th class="center th-tabela">Quantidade Solicitada</th>
                              <th class="center th-tabela w-2">Valor Total</th>
                           </tr>
                        </thead>
                        <tbody>
                           @forelse ($dados as $value)
                           <tr>
                              <td class="center">{{$value['item']->ordem}}</td>
                              <td>
                                 <a class="botao">{{$value['item']->objeto}}</a>
                                 <div class="dropdown">
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                       <p class="justificado p-4">
                                          @php print($value['item']->descricao) @endphp
                                       </p>
                                    </div>
                                 </div><!-- / dropdown -->
                              </td>
                              <td class="center">{{$value['item']->unidade->nome}}</td>
                              <td class="center">{{$value['empenhado']}}</td>
                              <td class="center font-weight-bold" id="max{{$value['item']->uuid}}">{{$value['saldo']}}</td>
                              <td class="text-right" id="valor{{$value['item']->uuid}}">{{$value['valor']}}</td>
                              <td >
                                 <input type="number" name="campos[]"  data-numero="{{$value['item']->uuid}}" min="0" max="{{$value['saldo']}}" class="form-control text-center">
                              </td>
                              <td>
                                 <input type="text" name="totalItem[]" id="totalItem{{$value['item']->uuid}}" disabled="" class="form-control text-right">
                              </td>
                           </tr>
                           @empty
                           <tr><td><center><i> Nenhum item encontrado </i></center></td></tr>
                           @endforelse
                        </tbody>
                     </table>
                  </div>
               @else   
                  <table align="center"><tr><td><font size="3"><i> Requisição Não Encontrada </i></font></td></tr></table>
               @endif
            </div>
         </div><!-- / row -->
         
         {{Form::open(['url' => 'contratacao/store', 'id' => 'form', 'method' => 'post', 'class' => 'form-padrao'])}}
            {{ Form::hidden('licitacao', $licitacao->uuid)}}
            
            <div class="row mt-2">
               @include('form.textarea', [
               'input' => 'observacao',
               'label' => 'Observações (opcional)',
               'value' => old($input ?? ''),
               'largura' => 12, 
               'attributes' => ['id' => 'observacao',  'rows'=>'3', 'style'=>'background: #eee' ]])
            </div><!-- / row -->
            
            <div class="row mt-2">
               @include('form.button', [
               'value' => 'Voltar',
               'largura'   => 3,
               'class'     => 'btn btn-primary btn-block',
               'url'       =>  route('licitacaoShow', [$licitacao->uuid]),
               'recuo'  => 3 ])

               @include('form.submit', [
               'input' => 'Salvar',
               'largura' => 3 ])
            </div>   
         {{Form::close()}} 

      </div><!-- / panel-body -->

      <div class="panel-footer">
         <div class="row">
            <div class="col-xs-4 col-md-6 text-center"><label>Fornecedor</label></div>
            <div class="col-xs-4 col-md-2 text-center"><label>Valor Total</label></div>
            <div class="col-xs-4 col-md-1 text-center"><label>Data</label></div>
         </div><!-- / row -->

         <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            @forelse ($contratacoes as $contratacao)
            <div class="panel panel-default">
               <div class="panel-heading" role="tab" id="headingOne">
                 <div class="row ">
                     <div class="col-xs-12 col-md-6">
                        <h5 class="panel-title">
                           <a role="button" data-toggle="collapse" data-parent="#accordion" href="#{{$contratacao->uuid}}" aria-expanded="false" aria-controls="collapseOne">
                             {{$contratacao->fornecedor->nome}}
                           </a>
                        </h5>
                     </div><!-- / col-md-6 -->
                      <div class="col-xs-4 col-md-2 text-center">
                        {{$contratacao->total}}
                     </div><!-- / col-md-2 -->
                      <div class="col-xs-4 col-md-1 text-center">
                        {{$contratacao->data}}
                     </div><!-- / col-md-2 -->
                     <div class="col-xs-4 col-md-offset-1 col-md-2">
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                           <div class="btn-group" role="group">
                              <a class="btn btn-default" type="button" href="{{route('contratacao.documento', $contratacao->uuid)}}" role="button" target="_black">
                                 <i class="fa fa-eye"></i>
                              </a>
                           </div>
                            <div class="btn-group" role="group">
                              <a class="btn btn-default" type="button" href="{{url('contratacao/pdf', $contratacao->uuid)}}" role="button" target="_black">
                                 <i class="fa fa-file-pdf-o"></i>
                              </a>
                           </div>
                           <div class="btn-group" role="group">
                              <form action="{{url('contratacao/apagar',  $contratacao->uuid)}}" method="post">
                                 {{csrf_field() }}
                                 {{method_field('DELETE') }}
                                 <button type="submit" class="btn btn-danger" role="button"><i class="fa fa-trash"></i></button>
                              </form>
                           </div>
                        </div>
                     </div><!-- / col-md-1-->
                  </div><!-- / row -->
               </div>
               <div id="{{$contratacao->uuid}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                  <div class="panel-body">
                        <div class="row row-fluid">
                           <div class="col-md-3 col-xs-6">
                              <label for="contrato">Contrato nº </label>
                              <input type="text" name="contrato" class="form-control contrato" id="contrato{{$contratacao->uuid}}" placeholder="000/0000" value="{{$contratacao->contrato}}">
                           </div>
                           <div class="col-md-3 col-xs-6">
                              <button data-numero="{{$contratacao->uuid}}" class="btn btn-success btn-block" type="button" name="update">Salvar</button>
                           </div><!-- / col-md-3 -->
                        </div><!-- / row -->

                        <div class="row">
                           <div class="col-md-12 col-xs-12">
                              <label for="contrato">Observações</label>
                              <textarea class="form-control" rows="4" name="observacao" id="observacao{{$contratacao->uuid}}">{{$contratacao->observacao}}</textarea>
                           </div>
                        </div><!-- / row -->
                  </div>
               </div>
            </div>
            @empty
            <tr><td colspan="7"><center><i>Nenhuma Solicitação de Empenho encontrada </i></center></td></tr>
            @endforelse
         </div><!-- / panel-group -->
      </div><!-- / panel-footer -->
   </div>
@endsection