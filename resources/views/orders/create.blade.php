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
            <div class="container col-md-4 mb-4">
                <div class="card">
                    <div class="card-header">
                        <span>Novo Pedido</span>
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
                            {{--Select Cliente--}}
                            <div class="mb-2">
                                <div class="form-group">
                                    {{ Form::label('customer_id','Cliente') }}
                                    <select class="form-select" id="customer_id" v-model="customer">
                                        <option :value="null" disabled>Selecione o cliente</option>
                                        <option v-for="customer in customers" :value="customer">
                                            @{{ customer.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{--Select Produto--}}
                            <div class="mb-2">
                                <div class="form-group">
                                    {{ Form::label('product_id','Produto') }}
                                    <select class="form-select" id="product_id" v-model="product" @change="adicionarProduto()" required>
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="product in products" v-bind:value="product">
                                            @{{ product.description }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{--Select Adicional--}}
                            <div class="mb-2">
                                <div class="form-group">
                                    {{ Form::label('aditional_id','Adicional') }}
                                    <select class="form-select" id="aditional_id" v-model="aditional" @change="adicionarAdicional()" required>
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="aditional in aditionals" :value="aditional">
                                            @{{ aditional.description }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{--Tipo de Pagamento--}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    {{ Form::label('payment_type','Tipo de Pagamento') }}
                                    <br>
                                    <select class="form-select bg-white" id="payment_type" v-model="paymentType" :required="true">
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="payment in payments" v-bind:value="payment.value">
                                            @{{ payment.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{--Status do pedido--}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    {{ Form::label('type','Tipo do Pedido') }}
                                    <br>
                                    <select class="form-select bg-white" id="type_order" v-model="type" :required="true">
                                        <option :value="null" disabled>Selecione</option>
                                        <option v-for="type in orderType" v-bind:value="type.value">
                                            @{{ type.text }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            {{--Data de Entrega--}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    {{ Form::label('date','Data de Entrega') }}
                                    {{ Form::date('date', date('Y-m-d'), ['class' => 'form-control bg-white', 'v-model' => 'date', 'required' => 'true']) }}
                                </div>
                            </div>
                            {{--Valor de Delivery--}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    {{ Form::label('deliveryFee','Taxa Delivery') }}
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        {{ Form::text('deliveryFee', null, ['class' => 'form-control mask-money bg-white', 'v-model' => 'deliveryFee']) }}
                                    </div>
                                </div>
                            </div>
                            {{--Valor de Desconto--}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    {{ Form::label('discount','Desconto') }}
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        {{ Form::text('discount', null, ['class' => 'form-control mask-money bg-white', 'v-model' => 'discount']) }}
                                    </div>
                                </div>
                            </div>
                            {{--Valor já pago--}}
                            <div class="col-md-6 mb-2">
                                <div class="form-group">
                                    {{ Form::label('total_paid','Valor Pago') }}
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">R$</span>
                                        {{ Form::text('total_paid', null, ['class' => 'form-control mask-money bg-white', 'v-model' => 'totalPaid']) }}
                                    </div>
                                </div>
                            </div>
                            {{--Texto de Obs--}}
                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="obs" class="col-md-4 col-form-label">Observacões</label>
                                    <textarea id="obs" rows="2" class="form-control bg-white" name="obs" v-model="obs"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Itens-->
            <div class="container col-md-8">
                <div class="card">
                    {{--Card Header--}}
                    <div class="card-header">
                        Itens do Pedido
                    </div>
                    {{--Card Body com os itens--}}
                    <div class="card-body" style="min-height: 379.05px">
                        <div class="mb-4" v-if="arrayProducts.length <= 0 && arrayAditionals.length <= 0">
                            <div class="d-flex flex-column text-center justify-content-center align-content-center align-items-center">
                                <img src="{{ asset('images/cartempty1.png') }}" alt="sem produtos">
                                <strong>Seu caixa está vazio no momento!</strong>
                            </div>
                        </div>

                        <div class="table-responsive" v-if="arrayProducts.length > 0">
                            <table class="table table-responsive">
                                <thead>
                                    <tr>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Qtd</th>
                                        <th class="text-center" scope="col">Valor Unitário</th>
                                        <th class="text-center" scope="col">Valor Total</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(productItem, index) in arrayProducts" :value="productItem">
                                        <td class="col-md-2"> Produto </td>
                                        <td class="col-md-3">@{{ productItem.description }}</td>
                                        <td class="col-md-1">@{{ productItem.quantity }}</td>
                                        <td class="col-md-2 text-center">R$ @{{ productItem.price_formated }}</td>
                                        <td class="col-md-2 text-center">R$ @{{ number_format(productItem.valueTotalProduct/100, '2', ',') }}</td>
                                        <td class="col-md-2">
                                            <div class="quantity-toggle text-end d-flex align-items-center justify-content-end">
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
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <span></span>
                        </div>

                        <div v-if="arrayAditionals.length > 0">
                            <table class="table">
                                <tbody>
                                    <tr v-for="(aditionalItem, index) in arrayAditionals" :value="aditionalItem">
                                        <td class="col-md-2"> Adicional </td>
                                        <td class="col-md-3">@{{ aditionalItem.description }}</td>
                                        <td class="col-md-1">@{{ aditionalItem.quantity }}</td>
                                        <td class="col-md-2 text-center">R$ @{{ aditionalItem.price_formated }}</td>
                                        <td class="col-md-2 text-center">R$ @{{ number_format(aditionalItem.valueTotalAdd/100, '2', ',') }}</td>
                                        <td class="col-md-2">
                                            <div class="quantity-toggle text-end d-flex align-items-center justify-content-end">
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
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div v-else>
                            <span></span>
                        </div>
                    </div>
                    {{--Card Footer com valores e botão de finalizar--}}
                    <div class="card-footer">
                        <div class="col-md-12">
                            <ul class="list-group mt-2 text-end">
                                <li class="list-group-item list-group-item-info"><strong>Valor Total:</strong> R$ @{{ total }}</li>
                            </ul>
                        </div>
                        <div class="row mt-2 mb-2 d-flex justify-content-between align-content-between">
                            <ul class="list-group mb-2 col-md-6 text-end" style="padding-left: 10px">
                                <li v-if="totalPaid != ''" class="list-group-item list-group-item-success"><strong>Valor Pago:</strong> R$ @{{ totalPaid }}</li>
                                <li v-else class="list-group-item list-group-item-success"><strong>Valor Pago:</strong> R$ 0,00</li>
                            </ul>
                            <ul class="list-group col-md-6 text-end" style="padding-left: 10px">
                                <li class="list-group-item list-group-item-danger"><strong>Falta Receber:</strong> R$ @{{ valueMissing }}</li>
                            </ul>
                        </div>
                        {{--Botão Finalizar--}}
                        <div class="col-md-12 mt-2">
                            <button class="btn btn-primary" style="width: 100%" v-on:click="submit()">
                                Finalizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
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
                orderType: [
                    {text: 'Encomenda', value: 'ORDER'},
                    {text: 'No Caixa', value: 'CASHIER'},
                ],
                paymentType: null,
                type: null,
            },
            watch: {},
            created() {
                var tzoffset        = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
                var localISOTime    = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
                this.date           = localISOTime.slice(0,10);

                for (var i = 0; i < this.products.length; i++) {
                    this.products[i].quantity = 0;
                    this.products[i].valueTotalProduct = this.products[i].price;
                }
                for (var i = 0; i < this.aditionals.length; i++) {
                    this.aditionals[i].quantity = 0;
                    this.aditionals[i].valueTotalAdd = this.aditionals[i].price;
                }
            },
            mounted() {
                $('#product_id').select2({
                    theme: "bootstrap",
                    width: '100%',
                }).change(function () {
                    console.log('change product')
                    app.product = $(this).find("option:selected").data().data.element._value;
                    app.adicionarProduto();
                });

                $('#aditional_id').select2({
                    theme: "bootstrap",
                    width: '100%',
                }).change(function () {
                    console.log('change aditional')
                    app.aditional = $(this).find("option:selected").data().data.element._value;
                    app.adicionarAdicional();
                });

                $('#customer_id').select2({
                    theme: "bootstrap",
                    width: '100%', tags: true
                }).change(function () {
                    console.log('change customer')
                    if ($(this).find("option:selected").data().data.selected === true) {
                        app.customer = $(this).find("option:selected").data().data.element._value;
                    } else {
                        app.customer = $(this).find("option:selected").data().data.text;
                    }
                });
                $('.mask-money').mask('000.000.000.000,00', {reverse: true, placeholder: '0.00'});
            },
            computed: {
                total: function () {
                    this.price          = this.price.toString().replace(/,/g, '');
                    this.deliveryFee    = this.deliveryFee.replace(/,/g, '');
                    this.discount       = this.discount.replace(/,/g, '');
                    this.totalPaid      = this.totalPaid.replace(/,/g, '');
                    this.totalAmount    = ((Number(this.price) + Number(this.deliveryFee)) - Number(this.discount));

                    let value = (((Number(this.price) + Number(this.deliveryFee)) - Number(this.discount)) / 100);

                    const paidCents = this.totalPaid
                    this.discount = this.formatReal(this.discount);
                    this.deliveryFee = this.formatReal(this.deliveryFee);
                    this.totalPaid = this.formatReal(this.totalPaid);

                    if (paidCents != '') {
                        app.getValueMissing(value, paidCents)
                    }

                    return this.number_format(value, '2', ',');
                }
            },
            methods: {
                submit() {
                    if (app.customer == null) {
                        alert('É necessário informar o cliente do pedido');
                        return true;
                    }

                    if (app.arrayProducts.length === 0) {
                        alert('É necessário informar pelo menos um produto');
                        return true;
                    }

                    if (app.paymentType == null) {
                        alert('É necessário informar o tipo do pagamento');
                        return true;
                    }

                    if (app.date == null) {
                        alert('É necessário informar a data de entrega do pedido');
                        return true;
                    }

                    if (app.type == null) {
                        alert('É necessário informar o tipo do pedido');
                        return true;
                    }

                    if (app.totalPaid == null || app.totalPaid ==  "") {
                        alert('É necessário informar o quanto foi pago do pedido');
                        return true;
                    }

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
                        type: app.type
                    }
                    console.log(data);
                    // return true;
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
                            app.arrayAditionals[i].valueTotalAdd = app.arrayAditionals[i].quantity * app.arrayAditionals[i].price;
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
                            app.arrayProducts[i].valueTotalProduct = app.arrayProducts[i].quantity * app.arrayProducts[i].price;
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

                        app.$set(app.arrayProducts, index, {
                            ...app.arrayProducts[index],
                            valueTotalProduct: app.arrayProducts[index].quantity * app.arrayProducts[index].price
                        });

                        app.price = Number(app.price) + Number(app.arrayProducts[index].price);
                        this.product = null;
                    } else {
                        app.$set(app.arrayAditionals, index, {
                            ...app.arrayAditionals[index],
                            quantity: app.arrayAditionals[index].quantity + 1
                        });

                        app.$set(app.arrayAditionals, index, {
                            ...app.arrayAditionals[index],
                            valueTotalAdd: app.arrayAditionals[index].quantity * app.arrayAditionals[index].price
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
                                    app.$set(app.products, i, {
                                        ...app.products[i],
                                        quantity: 0
                                    });
                                }
                            });

                            app.price = Number(app.price) - Number(app.arrayProducts[index].price);
                            app.arrayProducts.splice(index, 1);

                            return true;
                        }

                        app.$set(app.arrayProducts, index, {
                            ...app.arrayProducts[index],
                            quantity: app.arrayProducts[index].quantity - 1
                        });

                        app.$set(app.arrayProducts, index, {
                            ...app.arrayProducts[index],
                            valueTotalProduct: app.arrayProducts[index].quantity * app.arrayProducts[index].price
                        });

                        app.price = Number(app.price) - Number(app.arrayProducts[index].price);
                        this.product = null;
                    } else {
                        if (qtdAtual == 1) {
                            app.aditionals.filter(function (adicional, i) {
                                if (adicional.id === app.arrayAditionals[index].id) {
                                    app.$set(app.aditionals, i, {
                                        ...app.aditionals[i],
                                        quantity: 0
                                    });
                                }
                            });

                            app.price = Number(app.price) - Number(app.arrayAditionals[index].price);
                            app.arrayAditionals.splice(index, 1);

                            return true;
                        }

                        app.$set(app.arrayAditionals, index, {
                            ...app.arrayAditionals[index],
                            quantity: app.arrayAditionals[index].quantity - 1
                        });

                        app.$set(app.arrayAditionals, index, {
                            ...app.arrayAditionals[index],
                            valueTotalAdd: app.arrayAditionals[index].quantity * app.arrayAditionals[index].price
                        });

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
