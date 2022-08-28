@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href=" {{ route('orders.index') }}">Pedidos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Novo Pedido</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')


    <div class="container d-flex justify-content-center">
        <div class="card col-12 col-md-12 col-lg-12">
            <div class="card-header d-flex justify-content-between align-items-center">
                Novo Pedido
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

                <div class="container p-4">
                    <div class="row gx-5">
                        <div class="col">
                            <div class="p-3 bg-light text-center">
                                <div class="form-group mb-3">
                                    {{ Form::label('customer_id','Cliente') }}
                                    {{ Form::select('customer_id', $customers, null, ['class' => 'form-control', 'placeholder' => 'Selecione']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 bg-light text-center">
{{--                                <button data-bs-toggle="modal" data-bs-target="#modalAddProduto" class="btn btn-primary btn-sm text-center"> Adicionar Produto</button>--}}
                                <div class="form-group mb-3">
                                    {{ Form::label('product_id','Produtos') }}
                                    {{ Form::select('product_id', $products, null,['class' => 'form-select', 'placeholder' => 'Selecione']) }}
                                </div>
                            </div>
                        </div>
                        <div class="col">
                            <div class="p-3 bg-light text-center">
{{--                                <button data-bs-toggle="modal" data-bs-target="#modalAddProduto" class="btn btn-primary btn-sm text-center"> Adicionar Produto</button>--}}
                                <div class="form-group mb-3">
                                    {{ Form::label('aditional_id','Adicionais') }}
                                    {{ Form::select('aditional_id', $aditionals, null,['class' => 'form-select', 'placeholder' => 'Selecione']) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddProduto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Produto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        {{ Form::label('product_id','Produtos') }}
                        {{ Form::select('product_id', $products, null,['class' => 'form-select', 'placeholder' => 'Selecione']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAddAdicional" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Adicionar Adicional</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-3">
                        {{ Form::label('aditional_id','Adicionais') }}
                        {{ Form::select('aditional_id', $aditionals, null,['class' => 'form-select', 'placeholder' => 'Selecione']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Adicionar</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vue-cookies@1.7.0/vue-cookies.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $('#price').mask('000.000.000.000.000,00', {reverse: true});
    </script>

@endsection
