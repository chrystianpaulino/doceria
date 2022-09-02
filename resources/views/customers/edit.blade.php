@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('customers.index') }}>Clientes</a></li>
                <li class="breadcrumb-item"><a href={{ route('customers.show', $customer->id) }}> {{ $customer->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Editar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')


    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Editar cliente</span>
            </div>
            {{ Form::model($customer,['route' => ['customers.update', $customer->id], 'method' => 'PUT', 'class' => 'needs-validation']) }}

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
                        {{ Form::text('name', $customer->name,['class' => 'form-control', 'required']) }}
                    </div>


                    <div class="form-group mb-3">
                        {{ Form::label('phone','Telefone') }}
                        {{ Form::text('phone', $customer->phone, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('street','Rua') }}
                        {{ Form::text('street', $customer->street, ['class' => 'form-control']) }}
                    </div>


                    <div class="form-group mb-3">
                        {{ Form::label('street_number','Número') }}
                        {{ Form::text('street_number', $customer->street_number, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('neighborhood','Bairro') }}
                        {{ Form::text('neighborhood', $customer->neighborhood, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('city','Cidade') }}
                        {{ Form::text('city', $customer->city, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('state','UF') }}
                        {{ Form::text('state', $customer->state, ['class' => 'form-control']) }}
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('zipcode','CEP') }}
                        {{ Form::text('zipcode', $customer->zipcode, ['class' => 'form-control']) }}
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <div>
                        <a href="{{ route('customers.show', $customer->id) }}" class=" btn btn-outline-dark" >Cancelar</a>
                        <button class=" btn btn-primary text-white" type="submit">Salvar</button>
                    </div>
                </div>

            {{ Form::close() }}
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/cidades-estados-1.4-utf8.js') }}"></script>
    <script language="JavaScript" type="text/javascript" charset="utf-8">
        new dgCidadesEstados({
            cidade: document.getElementById('city'),
            estado: document.getElementById('state'),
        })
    </script>
@endsection
