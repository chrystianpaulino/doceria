@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href=" {{ route('orders.index') }}">Vendas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nova Venda</li>
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
                        <strong>Nova Venda</strong>
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
                        <div class="row col-md-12">
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('product_id','Produto') }}
                                </div>
                                <div class="form-group" style="display: inline-block; min-width: 80%">
                                    <select class="form-select" class="col-md-12" v-model="product" required>
                                        <option v-for="product in products" :value="product">
                                            @{{ product.description }}
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" v-on:click="adicionarProduto()"><i class="fas fa-plus"></i></button>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('aditional_id','Adicional') }}
                                </div>
                                <div class="form-group" style="display: inline-block; min-width: 80%">
                                    <select class="form-select" class="col-md-12" v-model="aditional">
                                        <option v-for="aditional in aditionals" :value="aditional">
                                            @{{ aditional.description }}
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" v-on:click="adicionarAdicional()"><i class="fas fa-plus"></i></button>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        {{ Form::label('customer_id','Cliente') }}
                                        <br>
                                        <select class="form-select" class="col-12" id="product" name="product" v-model="customer" required>
                                            <option v-for="customer in customers" :value="customer">
                                                @{{ customer.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        {{ Form::label('date','Data de entrega') }}
                                        {{ Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'v-model' => 'date', 'required' => 'true']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="obs" class="col-md-4 col-form-label text-md-right">Obs</label>
                                        <textarea id="obs" rows="2" class="form-control" name="obs" v-model="obs"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                {{--<div class="col-md-6">
                                    <div class="form-group mb-3">
                                        {{ Form::label('deliveryFee','Taxa delivery') }}
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                            {{ Form::number('deliveryFee', null, ['class' => 'form-control', 'v-model' => 'deliveryFee']) }}
                                        </div>
                                    </div>
                                </div>--}}
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        {{ Form::label('discount','Desconto') }}
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon1">R$</span>
                                            {{ Form::text('discount', null, ['class' => 'form-control mask-money-discount', 'v-model' => 'discount']) }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <button class="btn btn-primary p-2" v-on:click="submit()">Finalizar</button>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="container col-md-4">
                <div class="card">
                    <div class="card-header">
                        Itens da Venda
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-secondary">Produtos</li>
                            <li class="list-group-item" v-for="productItem in arrayProducts" :value="productItem">
                                <strong>@{{ productItem.description }}: </strong> R$ @{{ productItem.price_formated }}
                            </li>
                        </ul>
                        <br>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-secondary">Adicionais</li>
                            <li class="list-group-item" v-for="aditionalItem in arrayAditionals" :value="aditionalItem">
                                <strong>@{{ aditionalItem.description }}: </strong> R$ @{{ aditionalItem.price_formated }}
                            </li>
                        </ul>
                        <ul class="list-group mt-4">
                            <li class="list-group-item list-group-item-success">Total: R$ @{{ total }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection

@section('js')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js" integrity="sha512-Rdk63VC+1UYzGSgd3u2iadi0joUrcwX0IWp2rTh6KXFoAmgOjRS99Vynz1lJPT8dLjvo6JZOqpAHJyfCEZ5KoA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <script src="https://unpkg.com/vue-cookies@1.7.0/vue-cookies.js"></script>
    <script>
        Vue.config.devtools = true

        var app = new Vue({
            el: '#app',
            data: {
                products: @json($products),
                aditionals: @json($aditionals),
                customers: @json($customers),
                price: 0,
                totalAmount: 0,
                deliveryFee: '',
                discount: '',
                product: null,
                aditional: null,
                customer: null,
                date: new Date().toISOString().slice(0,10),
                obs: null,
                arrayProducts: [],
                arrayAditionals: []
            },
            watch: {

            },
            created() {
            },
            mounted() {
                // $('.mask-money-delivery').mask('000.000.000.000,00', {reverse: true, placeholder: '0.00'});
                $('.mask-money-discount').mask('000.000.000.000,00', {reverse: true, placeholder: '0.00'});
                // $(".mask-money-delivery").maskMoney({thousands:'', decimal:'.', allowZero:true});
                // $(".mask-money-discount").maskMoney({thousands:'', decimal:'.', allowZero:true});

            },
            computed: {
                total: function () {
                    console.log(this.deliveryFee)
                    console.log(this.discount)
                    this.price          = this.price.toString().replace(/,/g, '');
                    // this.deliveryFee    = this.deliveryFee.replace(/,/g, '');
                    this.discount       = this.discount.replace(/,/g, '');
                    /*const deliveryParaView = this.number_format(this.deliveryFee / 100, '2', ',');
                    const descontoParaView = this.number_format(this.discount / 100, '2', ',');
                    console.log(deliveryParaView)
                    console.log(descontoParaView)
                    console.log(this.deliveryFee)
                    console.log(this.discount)
                    this.deliveryFee = deliveryParaView;
                    this.discount = descontoParaView;
                    console.log('-')
                    console.log(this.deliveryFee)
                    console.log(this.discount)*/
                    this.totalAmount    = ((Number(this.price) + Number(this.deliveryFee)) - Number(this.discount));
                    let value           = (((Number(this.price) + Number(this.deliveryFee)) - Number(this.discount)) / 100);
                    return this.number_format(value, '2', ',');
                }
            },
            methods: {
                submit() {
                    if (app.arrayProducts.length == 0) {
                        alert('É necessário informar pelo menos um produto');
                        return true;
                    }

                    if (app.customer == null) {
                        alert('É necessário informar o cliente do pedido');
                        return true;
                    }

                    const data = {
                        arrayProducts: app.arrayProducts,
                        arrayAditionals: app.arrayAditionals,
                        obs: app.obs,
                        date: app.date,
                        customer: app.customer,
                        price: app.price,
                        total: app.totalAmount,
                        discount: app.discount,
                        deliveryFee: app.deliveryFee
                    }
                    console.log(data);
                    axios.post('{{ route('orders.store') }}', data).then(function (response) {
                        window.location.href = '/orders';
                    });
                },
                adicionarAdicional() {
                    if (app.aditional == null) {
                        alert('insira um adicional');
                        return true;
                    }
                    console.log('add adicional');
                    app.arrayAditionals.push(app.aditional);
                    app.price = Number(app.price) + Number(app.aditional.price);
                    this.aditional = null;
                },
                adicionarProduto() {
                    if (app.product == null) {
                        alert('insira um produto');
                        return true;
                    }
                    console.log('add produto');
                    console.log()
                    app.arrayProducts.push(app.product)
                    app.price = Number(app.price) + Number(app.product.price);
                    this.product = null;
                },
                number_format(number, decimals, dec_point, thousands_sep) {
                    // Strip all characters but numerical ones.
                    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
                    var n = !isFinite(+number) ? 0 : +number,
                        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                        s = '',
                        toFixedFix = function (n, prec) {
                            var k = Math.pow(10, prec);
                            return '' + Math.round(n * k) / k;
                        };
                    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
                    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
                    if (s[0].length > 3) {
                        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
                    }
                    if ((s[1] || '').length < prec) {
                        s[1] = s[1] || '';
                        s[1] += new Array(prec - s[1].length + 1).join('0');
                    }
                    return s.join(dec);
                },
            }
        })

    </script>

@endsection
