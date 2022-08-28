@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('feedstocks.index') }}>Insumos</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Visualizar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Cliente</strong>
                <a href="{{ route('feedstocks.edit', $feedstock->id) }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-pencil"></i> Editar</a>
            </div>
            <div class="card-body">

                <div class="form-group mb-3">
                    {{ Form::label('name','Nome') }}
                    {{ Form::text('name', $feedstock->name, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('price','Preço') }}
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                        {{ Form::text('price', 'R$ ' . \App\Helpers\showCentsValue($feedstock->price) , ['class' => 'form-control', 'readonly']) }}
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
