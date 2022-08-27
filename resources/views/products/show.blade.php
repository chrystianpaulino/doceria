@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('products.index') }}>Produtos</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Visualizar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Produto</strong>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-pencil"></i> Editar</a>
            </div>
            <div class="card-body">

                <div class="form-group mb-3">
                    {{ Form::label('description','Nome') }}
                    {{ Form::text('description', $product->description, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('long_description','Descrição') }}
                    {{ Form::text('long_description', $product->long_description, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('price','Preço') }}
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                        {{ Form::text('price', \App\Helpers\showCentsValue($product->price) ,['class' => 'form-control text-uppercase mask-money', 'readonly']) }}
                    </div>
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('status','Status') }}
                    {{ Form::text('status', $product->status_name, ['class' => 'form-control', 'readonly']) }}
                </div>

            </div>
        </div>
    </div>

@endsection
