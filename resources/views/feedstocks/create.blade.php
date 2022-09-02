@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('feedstocks.index') }}">Insumos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Novo Insumo</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Novo Insumo</span>
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
                {{ Form::open(['route' => 'feedstocks.store', 'class' => 'needs-validation']) }}
                    <div class="form-group mb-3">
                        {{ Form::label('name','Nome') }}
                        {{ Form::text('name', null,['class' => 'form-control', 'required']) }}
                    </div>
                    <div class="form-group mb-3">
                        {{ Form::label('price','Preco') }}
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            {{ Form::text('price', null,['class' => 'form-control text-uppercase mask-money']) }}
                        </div>
                    </div>
                    <div class="form-group mb-3">
                        <button class="w-100 btn btn-primary" type="submit">Salvar</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $('#price').mask('000.000.000.000.000,00', {reverse: true});
    </script>
@endsection
