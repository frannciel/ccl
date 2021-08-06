@extends('site.layouts.index')

@section('content')
<div class="flex">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{route('.home')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('licitacao.index')}}">Licitações</a></li>
            <li class="breadcrumb-item"><a href="{{route('licitacao.show',  $licitacao->uuid)}}">Licitação nº {{$licitacao->ordem ?? '' }}</a></li>
            <li class="breadcrumb-item"><a href="{{route('licitacao.importar',  $licitacao->uuid)}}">Importar</a></li>
            <li class="breadcrumb-item active" aria-current="page">Participantes</li>
        </ol>
    </nav>
    <h1 Class="page-header page-title">Importar Participantes (Excel)</h1>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-12">
                <h3>
                    <i class="fa fa-shopping-cart "></i>
                    Licitação n° {{$licitacao->ordem ?? '' }}
                </h3>
                <p><label> Objeto:</label> {{$licitacao->objeto ?? ''}}</p>
            </div><!-- / col -->
        </div><!-- / row -->
    </div><!-- / panel-heading -->
</div><!-- / panel -->
<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="row">
            <div class="col-md-1">Nº Item</div>
            <div class="col-md-3">Descrição do Item</div>
            <div class="col-md-2">Unidade</div>
            <div class="col-md-2">Preços Unitário</div>
            <div class="col-md-2">Desdobrado?</div>
            <div class="col-md-2">Desmenbrado</div>

        </div>
    </div>
</div>

{{Form::open(['route' => ['uasg.importarStore', $licitacao->uuid], 'method' => 'POST', 'class' => 'form-padrao'])}}
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        @foreach($itens as $key => $item)
            <div class="panel panel-default">
                <div class="panel-heading pointer" role="tab" id="heading{{$key}}" data-toggle="collapse" data-parent="#accordion" href="#collapse{{$key}}" aria-expanded="false" aria-controls="collapse{{$key}}">
                    <div class="row">
                        <div class="col-md-1">{{$item['item']}}</div>
                        <div class="col-md-3">{{$item['objeto']}}</div>
                        <div class="col-md-2">{{$item['unidade']}}</div>
                        <div class="col-md-2">{{$item['preco']}}</div>
                        @if($item['subrogado'])
                            <div class="col-md-2">Sim</div>
                            <div class="col-md-2">
                                <input type="text" name="desmembrados['{{$item['item']}}']" class="form-control" value="{{$item['desmembrado']}}">
                            </div>
                        @else
                            <div class="col-md-2">Não</div>
                            <div class="col-md-2">
                                <input type="text" name="desmembrados['{{$item['item']}}']" class="form-control"  disabled="">
                            </div>
                        @endif

                    </div>
                </div>
                <div id="collapse{{$key}}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{$key}}">
                    <div class="panel-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th class="center"><input type="checkbox" class="checkboxAll" name="{{$key}}"></th>
                                    <th class="center">Uasg</th>
                                    <th class="center">Entidade Participante</th>
                                    <th class="center">Cidade/Estado</th>
                                    <th class="center">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($participantes->where('item', $item['item']) as $chave => $participante)
                                <tr>
                                    <td>
                                        <input type="checkbox" class="checkbox{{$key}}" name="participantes[]" value="{{$chave}}" >
                                    </td>
                                    <td class="center">{{$participante['uasg']}}</td>
                                    <td>{{$participante['nome']}}</td>
                                    <td>{{$participante['cidade'].' - '.$participante['estado']}}</td>
                                    <td class="center">{{$participante['quantidade']}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    </div>			

    <div class="row">
        <div class="col-md-3">
            <a href="{{route('licitacao.importar', $licitacao->uuid)}}" class="btn btn-primary btn-block" type="button">Cancelar</a>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-success btn-block">Salvar</button>
        </div>
        <div class="col-md-3">
            <button class="btn btn-warning btn-block" type="button" id="marcarTodos" data-check="false">Marcar Todos</button>
        </div>
    </div><!-- / row -->
{{Form::close()}} 
@endsection