@extends('site.layouts.index')

@section('content')
    <div class="row">
        <h2 Class="page-header page-title">Apresentação</h2>
    </div>

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <p>Freelancer is a free bootstrap theme created by Start Bootstrap. The download includes the complete source files including HTML, CSS, and JavaScript as well as optional LESS stylesheets for easy customization.</p>
            <p>Whether you're a student looking to showcase your work, a professional looking to attract clients, or a graphic artist looking to share your projects, this template is the perfect starting point!</p>
        </div>
    </div>

    <div class="row">
            <h2 Class="page-header page-title">Acesso Rápido</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-6" id="card-fornecedor">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-users fa-5x"></i>
                        </div>
                    </div>
                </div>
                <a href="{{route('fornecedor.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">Fornecedores</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-6" id="card-requisicao">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-shopping-cart fa-5x"></i>
                        </div>
                    </div>
                </div>
                <a href="{{route('requisicao.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">Requisições</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-6" id="card-licitacao">
            <div class="panel panel-gold"><!-- orchid -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-legal fa-5x"></i>
                        </div>
                    </div>
                </div>
                <a href="{{route('licitacao.index')}}">
                    <div class="panel-footer">
                        <span class="pull-left">Licitações</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 col-6" id="card-estudo-preliminar">
            <div class="panel panel-default"><!-- cade -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-file-text fa-5x"></i>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Estudo Preliminar</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-6" id="card-mapa-risco">
            <div class="panel panel-default"><!-- gold -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-warning fa-5x"></i>
                        </div>
                    </div>
                </div>
                <a href="#" >
                    <div class="panel-footer">
                        <span class="pull-left">Mapa de Risco</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-6" id="card-relatorio">
            <div class="panel panel-default"><!-- Não defiido no css -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <i class="fa fa-bar-chart-o fa-5x"></i>
                        </div>
                    </div>
                </div>
                <a href="#">
                    <div class="panel-footer">
                        <span class="pull-left">Relatórios</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
