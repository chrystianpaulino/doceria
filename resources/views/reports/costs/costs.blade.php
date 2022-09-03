@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Relatórios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Despesas</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center mb-4">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                Despesas
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{ Form::open(['route' => 'reports.costs', 'class' => 'needs-validation']) }}
                    <div class="form-group mb-3">
                        {{ Form::label('provider_id','Fornecedor Específico?') }}
                        {{ Form::select('provider_id', $providers, null,['class' => 'form-select', 'placeholder' => 'Selecione', 'autocomplete' => 'off']) }}
                        <small>Caso deseje, informe um fornecedor específico (opcional)</small>
                    </div>
                    <div class="form-group mb-3">
                        {{ Form::label('from','Data de') }}
                        {{ Form::date('from', null,['class' => 'form-control', 'autocomplete' => 'off', 'required' => 'true']) }}
                        <small>Informe o início do período do relatório (obrigatório)</small>
                    </div>
                    <div class="form-group mb-3">
                        {{ Form::label('to','Data até') }}
                        {{ Form::date('to', null,['class' => 'form-control', 'autocomplete' => 'off', 'required' => 'true']) }}
                        <small>Informe o fim do período do relatório (obrigatório)</small>
                    </div>
                    <div class="form-group mb-3">
                        <button class="w-100 btn btn-primary" type="submit">Gerar</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection


@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script>

        $('.date').mask('00/00/0000');

    </script>
@endsection
