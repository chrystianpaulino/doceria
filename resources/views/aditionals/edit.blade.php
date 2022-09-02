@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('aditionals.index') }}>Adicionais</a></li>
                <li class="breadcrumb-item"><a href={{ route('aditionals.show', $aditional->id) }}> {{ $aditional->description }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Editar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')


    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-10 col-lg-6">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Editar adicional</span>
            </div>
            {{ Form::model($aditional,['route' => ['aditionals.update', $aditional->id], 'method' => 'PUT', 'class' => 'needs-validation']) }}

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
                        {{ Form::label('description','Descrição') }}
                        {{ Form::text('description', $aditional->description,['class' => 'form-control', 'required']) }}
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('price','Preço') }}
                        <div class="input-group">
                            <span class="input-group-text" id="basic-addon1">R$</span>
                            {{ Form::text('price', $aditional->price,['class' => 'form-control text-uppercase mask-money']) }}
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        {{ Form::label('status','Status') }}
                        {{ Form::select('status', ['00' => 'Inativo', '01' => 'Ativo'], $aditional->status, ['class' => 'form-control']) }}
                    </div>

                </div>
                <div class="card-footer d-flex justify-content-end align-items-center">
                    <div>
                        <a href="{{ route('aditionals.show', $aditional->id) }}" class=" btn btn-outline-dark" >Cancelar</a>
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
        $(document).ready(function() {
            $('#price').mask('000.000.000.000.000,00', {reverse: true});
        });
    </script>
@endsection
