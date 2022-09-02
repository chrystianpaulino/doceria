@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('providers.index') }}>Fornecedores</a></li>
                <li class="breadcrumb-item"><a href={{ route('providers.show', $provider->id) }}> {{ $provider->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Editar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')


    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Editar Fornecedor</span>
            </div>
            {{ Form::model($provider,['route' => ['providers.update', $provider->id], 'method' => 'PUT', 'class' => 'needs-validation']) }}

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

                <div class="form-group mb-3">
                    {{ Form::label('name','Nome') }}
                    {{ Form::text('name', null,['class' => 'form-control', 'required']) }}
                </div>
                <div class="form-group mb-3">
                    {{ Form::label('price','Preco') }}
                    {{ Form::text('phone', null,['class' => 'form-control phone', 'required']) }}
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end align-items-center">
                <div>
                    <a href="{{ route('providers.show', $provider->id) }}" class=" btn btn-outline-dark">Cancelar</a>
                    <button class=" btn btn-primary text-white" type="submit">Salvar</button>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $(".phone").mask("(99) 99999-9999")
    </script>
@endsection
