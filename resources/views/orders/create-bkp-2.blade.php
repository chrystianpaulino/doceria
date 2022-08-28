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

    <div class="container" id="app">
        <div class="row">
            <div class="container col-md-8">
                <div class="card">
                    <div class="card-header">
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

                        <form @submit.prevent="adicionarItem()" id="formAdicionarProduto">
                            <div class="container p-4">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="p-3 bg-light text-center">
                                            <div class="form-group mb-3">
                                                {{ Form::label('product_id','Produto') }}
                                                <br>
                                                <select class="form-select" class="col-12" id="product" name="product" v-model="fields.product">
                                                    <option v-for="product in products" :value="product">
                                                        @{{ product.description }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="p-3 bg-light text-center">
                                            <div class="form-group mb-3">
                                                {{ Form::label('aditional_id','Adicional') }}
                                                <br>
                                                <select class="form-select" class="col-12" id="aditional" name="aditional" v-model="fields.aditional">
                                                    <option v-for="aditional in aditionals" :value="aditional">
                                                        @{{ aditional.description }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Adicionar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container col-md-4">
                <div class="card">
                    <div class="card-header">
                        Itens
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item" v-for="item in selecteds" :value="item">
                                @{{ item }}
                            </li>
                        </ul>
                        <ul class="list-group">
                            <li class="list-group-item">
                                Total: R$ @{{ total }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="row d-flex">
            <div class="container col-md-8">
                <div class="card">
                    <div class="card-header">
                        Dados da venda
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

                        <form @submit.prevent="submit()" id="formSubmit">
                            <div class="container p-4">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="p-3 bg-light text-center">
                                            <div class="form-group mb-3">
                                                {{ Form::label('customer_id','Cliente') }}
                                                <br>
                                                <select class="form-select" class="col-12" id="product" name="product" v-model="fields.customer">
                                                    <option v-for="customer in customers" :value="customer">
                                                        @{{ customer.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 bg-light text-center">
                                            <div class="form-group mb-3">
                                                {{ Form::label('date','Data de entrega') }}
                                                {{ Form::date('date', null, ['class' => 'form-control', 'v-model' => 'fields.date']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="p-3 bg-light text-center">
                                            <div class="form-group mb-3">
                                                <label for="obs" class="col-md-4 col-form-label text-md-right">Obs</label>
                                                <textarea id="obs" rows="1" class="form-control" name="obs" v-model="fields.obs"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-block text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Finalizar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    {{--    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>--}}
    <script src="https://unpkg.com/vue-cookies@1.7.0/vue-cookies.js"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $('#price').mask('000.000.000.000.000,00', {reverse: true});

        var app = new Vue({
            el: '#app',
            data: {
                products: @json($products),
                aditionals: @json($aditionals),
                customers: @json($customers),
                total: 0,
                fields: {},
                selecteds: [],
                data: null,
                obs: null,
                customer: null,
            },
            methods: {
                adicionarItem() {
                    console.log('add');
                    console.log(this.fields)

                    _.forEach(this.fields, function (item) {
                        console.log('porra')
                        console.log(item.description)
                        console.log(item.price)
                        app.selecteds.push(item.description)
                        app.total = app.total + item.price;
                    });

                },
                submit() {
                    console.log('submit');
                    console.log(app.fields)
                    console.log(app.selecteds)
                    console.log(app.total)
                    console.log(app.data)
                    console.log(app.obs)
                    console.log(app.customer)
                }
            }
        })

    </script>

@endsection
