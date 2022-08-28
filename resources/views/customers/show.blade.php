@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('customers.index') }}>Clientes</a></li>
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
                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-primary"><i
                        class="fas fa-pencil"></i> Editar</a>
            </div>
            <div class="card-body">

                <div class="form-group mb-3">
                    {{ Form::label('name','Nome') }}
                    {{ Form::text('name', $customer->name, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('phone','Telefone') }}
                    {{ Form::text('phone', $customer->phone, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('street','Rua') }}
                    {{ Form::text('street', $customer->street, ['class' => 'form-control', 'readonly']) }}
                </div>


                <div class="form-group mb-3">
                    {{ Form::label('street_number','Número') }}
                    {{ Form::text('street_number', $customer->street_number, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('neighborhood','Bairro') }}
                    {{ Form::text('neighborhood', $customer->neighborhood, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('city','Cidade') }}
                    {{ Form::text('city', $customer->city, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('state','UF') }}
                    {{ Form::text('state', $customer->state, ['class' => 'form-control', 'readonly']) }}
                </div>

                <div class="form-group mb-3">
                    {{ Form::label('zipcode','CEP') }}
                    {{ Form::text('zipcode', $customer->zipcode, ['class' => 'form-control', 'readonly']) }}
                </div>

            </div>
        </div>
    </div>

@endsection
