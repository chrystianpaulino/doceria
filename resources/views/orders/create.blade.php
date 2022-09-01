@extends('layouts.app')

@section('css')
    <style>
        .quantity-toggle {
            display: flex;
        }

        .quantity-input {
            border: 0;
            border-top: 2px solid #ddd;
            border-bottom: 2px solid #ddd;
            width: 2.5rem;
            text-align: center;
            padding: 0 .5rem;
        }

        .quantity-button {
            border-radius: 5px;
            border: 1px solid #ddd;
            background: #f5f5f5;
            color: #888;
            cursor: pointer;
        }
    </style>
@endsection

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
            <div class="container col-md-8 mb-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Novo Pedido</strong>
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
                        <div class="row col-md-12 m-0 d-flex">
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('product_id','Produto') }}
                                </div>
                                <div class="form-group" style="display: inline-block; min-width: 80%">
                                    <select class="form-select" v-model="product" required>
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="product in products" :value="product">
                                            @{{ product.description }}
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" v-on:click="adicionarProduto()"><i class="fas fa-plus"></i> </button>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('aditional_id','Adicional') }}
                                </div>
                                <div class="form-group" style="display: inline-block; min-width: 80%">
                                    <select class="form-select" v-model="aditional">
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="aditional in aditionals" :value="aditional">
                                            @{{ aditional.description }}
                                        </option>
                                    </select>
                                </div>
                                <button class="btn btn-primary" v-on:click="adicionarAdicional()"><i
                                        class="fas fa-plus"></i></button>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('customer_id','Cliente') }}
                                    <br>
                                    <select class="form-select" class="col-12" id="product" name="product"
                                            v-model="customer" required>
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="customer in customers" :value="customer">
                                            @{{ customer.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('date','Data de entrega') }}
                                    {{ Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'v-model' => 'date', 'required' => 'true']) }}
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="obs" class="col-md-4 col-form-label">Obs</label>
                                    <textarea id="obs" rows="2" class="form-control" name="obs"
                                              v-model="obs"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mt-4">
                                    {{ Form::label('deliveryFee','Taxa delivery') }}
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        {{ Form::text('deliveryFee', null, ['class' => 'form-control mask-money', 'v-model' => 'deliveryFee']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('discount','Desconto') }}
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        {{ Form::text('discount', null, ['class' => 'form-control mask-money', 'v-model' => 'discount']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('payment_type','Tipo de pagamento') }}
                                    <br>
                                    <select class="form-select" class="col-12" id="paymentType" name="paymentType" v-model="paymentType" :required="true">
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="payment in payments" v-bind:value="payment.value">
                                            @{{ payment.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mt-4">
                                <div class="form-group">
                                    {{ Form::label('total_paid','Valor pago') }}
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        {{ Form::text('total_paid', null, ['class' => 'form-control mask-money', 'v-model' => 'totalPaid']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button class="btn btn-primary" style="width: 100%" v-on:click="submit()">
                                    Finalizar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container col-md-4">
                <div class="card">
                    <div class="card-header">
                        Itens do Pedido
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-secondary">Produtos</li>
                            <template v-if="arrayProducts.length > 0">
                                <li class="list-group-item d-flex align-items-center justify-content-between" v-for="(productItem, index) in arrayProducts" :value="productItem">
                                    <span class="badge bg-info me-3"> @{{ productItem.quantity }}</span> <strong class="me-1">@{{ productItem.description }}: </strong> <span> R$ @{{ productItem.price_formated }}</span>
                                    <div class="quantity-toggle">
                                        <div class="me-2" v-if="productItem.quantity == 1">
                                            <button class="btn btn-outline-danger" title="Diminuir um" v-on:click="decrement(index, 'P', productItem.quantity)"> Remover </button>
                                        </div>
                                        <div class="me-2" v-else>
                                            <button class="btn btn-outline-info" title="Diminuir um" v-on:click="decrement(index, 'P', productItem.quantity)"> - </button>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-outline-info me-2" title="Acrescentar um" v-on:click="increment(index, 'P')"> + </button>
                                        </div>
                                    </div>
                                </li>
                            </template>
                            <template v-else>
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <span> Não há produtos selecionados para este pedido</span>
                                </li>
                            </template>
                        </ul>
                        <br>
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-secondary">Adicionais</li>
                            <template v-if="arrayAditionals.length > 0">
                                <li class="list-group-item d-flex align-items-center justify-content-between" v-for="(aditionalItem, index) in arrayAditionals" :value="aditionalItem">
                                    <span class="badge bg-info me-3"> @{{ aditionalItem.quantity }}</span> <strong class="me-1">@{{ aditionalItem.description }}: </strong> <span> R$ @{{ aditionalItem.price_formated }}</span>
                                    <div class="quantity-toggle">
                                        <div class="me-2" v-if="aditionalItem.quantity == 1">
                                            <button class="btn btn-outline-danger" title="Diminuir um" v-on:click="decrement(index, 'A', aditionalItem.quantity)"> Remover </button>
                                        </div>
                                        <div class="me-2" v-else>
                                            <button class="btn btn-outline-info" title="Diminuir um" v-on:click="decrement(index, 'A', aditionalItem.quantity)"> - </button>
                                        </div>
                                        <div class="">
                                            <button class="btn btn-outline-info me-2" title="Acrescentar um" v-on:click="increment(index, 'A')"> + </button>
                                        </div>
                                    </div>
                                </li>
                            </template>
                            <template v-else>
                                <li class="list-group-item d-flex align-items-center justify-content-between">
                                    <span> Não há adicionais selecionados para este pedido</span>
                                </li>
                            </template>
                        </ul>
                        <ul class="list-group mt-4">
                            <li class="list-group-item list-group-item-success">Total: R$ @{{ total }}</li>
                        </ul>
                        <ul class="list-group mt-4">
                            <li class="list-group-item list-group-item-success">Pago: R$ @{{ totalPaid }}</li>
                        </ul>
                        <ul class="list-group mt-4">
                            <li class="list-group-item list-group-item-success">Faltando: R$ @{{ valueMissing }}</li>
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
                valueMissing: "0,00",
                deliveryFee: '',
                discount: '',
                totalPaid: '',
                product: null,
                aditional: null,
                customer: null,
                date: null,
                obs: null,
                arrayProducts: [],
                arrayAditionals: [],
                payments: [
                    {text: 'Cartão', value: 'CARTAO'},
                    {text: 'Pix', value: 'PIX'},
                    {text: 'Dinheiro', value: 'DINHEIRO'}
                ],
                paymentType: null,
            },
            watch: {},
            created() {
                for (var i = 0; i < this.products.length; i++) {
                    this.products[i].quantity = 0;
                }
                for (var i = 0; i < this.aditionals.length; i++) {
                    this.aditionals[i].quantity = 0;
                }
            },
            mounted() {
                $('.mask-money').mask('000.000.000.000,00', {reverse: true, placeholder: '0.00'});
            },
            computed: {
                total: function () {
                    console.log('total')

                    this.price          = this.price.toString().replace(/,/g, '');
                    this.deliveryFee    = this.deliveryFee.replace(/,/g, '');
                    this.discount       = this.discount.replace(/,/g, '');
                    this.totalPaid      = this.totalPaid.replace(/,/g, '');
                    this.totalAmount    = ((Number(this.price) + Number(this.deliveryFee)) - Number(this.discount));

                    let value = (((Number(this.price) + Number(this.deliveryFee)) - Number(this.discount)) / 100);

                    const paidCents = this.totalPaid
                    console.log(paidCents)
                    this.discount = this.formatReal(this.discount);
                    this.deliveryFee = this.formatReal(this.deliveryFee);
                    this.totalPaid = this.formatReal(this.totalPaid);
                    console.log(this.totalPaid);

                    if (paidCents != '') {
                        console.log('diferente')
                        app.getValueMissing(value, paidCents)
                    }

                    return this.number_format(value, '2', ',');
                }
            },
            methods: {
                submit() {
                    /*if (app.arrayProducts.length == 0) {
                        alert('É necessário informar pelo menos um produto');
                        return true;
                    }

                    if (app.customer == null) {
                        alert('É necessário informar o cliente do pedido');
                        return true;
                    }

                    if (app.paymentType == null) {
                        alert('É necessário informar o tipo do pagamento');
                        return true;
                    }

                    if (app.date == null) {
                        alert('É necessário informar a data de entrega do pedido');
                        return true;
                    }*/
                    const data = {
                        arrayProducts: app.arrayProducts,
                        arrayAditionals: app.arrayAditionals,
                        obs: app.obs,
                        date: app.date,
                        customer: app.customer,
                        paymentType: app.paymentType,
                        price: app.price,
                        total: app.totalAmount,
                        discount: app.discount,
                        deliveryFee: app.deliveryFee,
                        totalPaid: app.totalPaid,
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

                    if (app.aditional.quantity === 0) {
                        app.arrayAditionals.push(app.aditional);
                    }

                    for (var i = 0; i < app.arrayAditionals.length; i++) {
                        if (app.aditional.id === app.arrayAditionals[i].id) {
                            app.arrayAditionals[i].quantity += 1;
                        }
                    }

                    app.price = Number(app.price) + Number(app.aditional.price);
                    this.aditional = null;
                },
                adicionarProduto() {
                    if (app.product == null) {
                        alert('insira um produto');
                        return true;
                    }

                    if (app.product.quantity === 0) {
                        app.arrayProducts.push(app.product)
                    }

                    for (var i = 0; i < app.arrayProducts.length; i++) {
                        if (app.product.id === app.arrayProducts[i].id) {
                            app.arrayProducts[i].quantity += 1;
                        }
                    }

                    app.price = Number(app.price) + Number(app.product.price);
                    this.product = null;
                },
                increment(index, type) {
                    if (type === 'P') {
                        app.$set(app.arrayProducts, index, {
                            ...app.arrayProducts[index],
                            quantity: app.arrayProducts[index].quantity + 1
                        });
                        app.price = Number(app.price) + Number(app.arrayProducts[index].price);
                        this.product = null;
                    } else {
                        app.$set(app.arrayAditionals, index, {
                            ...app.arrayAditionals[index],
                            quantity: app.arrayAditionals[index].quantity + 1
                        });
                        app.price = Number(app.price) + Number(app.arrayAditionals[index].price);
                        this.product = null;
                    }
                },
                decrement(index, type, qtdAtual) {
                    if (type === 'P') {
                        if (qtdAtual == 1) {
                            app.products.filter(function (produto, i) {
                                if (produto.id === app.arrayProducts[index].id) {
                                    app.$set(app.products, i, {...app.products[i], quantity: 0});
                                }
                            });
                            app.price = Number(app.price) - Number(app.arrayProducts[index].price);
                            app.arrayProducts.splice(index, 1);
                            return true;
                        }
                        app.$set(app.arrayProducts, index, {...app.arrayProducts[index], quantity: app.arrayProducts[index].quantity - 1});
                        app.price = Number(app.price) - Number(app.arrayProducts[index].price);
                        this.product = null;
                    } else {
                        if (qtdAtual == 1) {
                            app.aditionals.filter(function (adicional, i) {
                                if (adicional.id === app.arrayAditionals[index].id) {
                                    app.$set(app.aditionals, i, {...app.aditionals[i], quantity: 0});
                                }
                            });
                            app.price = Number(app.price) - Number(app.arrayAditionals[index].price);
                            app.arrayAditionals.splice(index, 1);
                            return true;
                        }
                        app.$set(app.arrayAditionals, index, {...app.arrayAditionals[index], quantity: app.arrayAditionals[index].quantity - 1});
                        app.price = Number(app.price) - Number(app.arrayAditionals[index].price);
                        this.aditional = null;
                    }
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
                getMoney(str) {
                    return parseInt(str.replace(/[\D]+/g, ''));
                },
                formatReal(int) {
                    var tmp = int + '';
                    tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
                    if (tmp.length > 6)
                        tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

                    return tmp;
                },
                getValueMissing(value, totalPaid) {
                    const valueMissing  = value - (totalPaid / 100);
                    app.valueMissing    = this.number_format(valueMissing, '2', ',');
                }
            }
        })

    </script>

@endsection
