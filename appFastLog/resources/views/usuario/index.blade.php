@extends('layouts.main')
@section('page', 'usuario-index')
@section('content')
    <div class="row">
        <!-- Card Total de Usuários -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-primary card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Total de Usuários</p>
                                <h4 class="card-title">200</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Usuários Ativos -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-success card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-user-check"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Ativos</p>
                                <h4 class="card-title">180</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Novos Usuários -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-info card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-user-plus"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Novos (Mês)</p>
                                <h4 class="card-title">30</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Usuários Inativos -->
        <div class="col-sm-6 col-md-3">
            <div class="card card-stats card-danger card-round">
                <div class="card-body">
                    <div class="row">
                        <div class="col-5">
                            <div class="icon-big text-center">
                                <i class="fas fa-user-times"></i>
                            </div>
                        </div>
                        <div class="col-7 col-stats">
                            <div class="numbers">
                                <p class="card-category">Inativos</p>
                                <h4 class="card-title">20</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabela de Usuários -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Lista de Usuários</h4>
                        <button id="novoUsuarioBtn" class="btn btn-primary btn-round ml-auto">
                            <i class="fa fa-plus"></i>
                            Novo Usuário
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table style="width:100%" id="usuarios-table" class="table table-responsive table-hover justify-content-center align-items-center">
                      
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
