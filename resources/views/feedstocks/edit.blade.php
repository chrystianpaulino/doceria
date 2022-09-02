@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('feedstocks.index') }}>Matéria-Prima</a></li>
                <li class="breadcrumb-item"><a
                        href={{ route('feedstocks.show', $feedstock->id) }}> {{ $feedstock->name }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Editar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')


    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Editar Insumo</span>
            </div>
            {{ Form::model($feedstock,['route' => ['feedstocks.update', $feedstock->id], 'method' => 'PUT', 'class' => 'needs-validation']) }}

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
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                        {{ Form::text('price', null,['class' => 'form-control text-uppercase mask-money']) }}
                    </div>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-end align-items-center">
                <div>
                    <a href="{{ route('feedstocks.show', $feedstock->id) }}" class=" btn btn-outline-dark">Cancelar</a>
                    <button class=" btn btn-primary " type="submit">Salvar</button>
                </div>
            </div>

            {{ Form::close() }}
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $('#price').mask('000.000.000.000.000,00', {reverse: true});
    </script>
@endsection
