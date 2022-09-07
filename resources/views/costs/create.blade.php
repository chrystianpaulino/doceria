@extends('layouts.app')

@section('css')
    <style>


        button {
            background-color: #16cc9b;
            border: 2px solid #16cc9b;
            color: #ffffff;
            transition: all 0.25s linear;
            cursor: pointer;
        }

        /*button::after {*/
        /*    position: relative;*/
        /*    right: 0;*/
        /*    content: " \276f";*/
        /*    transition: all 0.15s linear;*/
        /*}*/

        button:hover {
            background-color: #518df5;
            border-color: #518df5;
        }

        button:hover::after {
            right: -5px;
        }

        button:focus {
            outline: none;
        }

        ul {
            padding: 0;
            margin: 0;
            list-style-type: none;
        }

        input {
            transition: all 0.25s linear;
        }

        input[type=number]::-webkit-inner-spin-button,
        input[type=number]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            margin: 0;
        }

        input {
            outline: none;
        }


        /* --- PRODUCT LIST --- */
        .feedstocks {
            border-top: 1px solid #ddd;
        }

        .feedstocks > li {
            padding: 1rem 0;
            border-bottom: 1px solid #ddd;
        }

        .col, .quantity, .remove {
            float: left;
        }

        .col.left {
            width: 70%;
        }

        .col.right {
            width: 30%;
            position: absolute;
            right: 0;
            top: calc(50% - 30px);
        }

        .detail {
            padding: 0 0.5rem;
            line-height: 2.2rem;
        }

        .detail .name {
            font-size: 1.1rem;
        }

        .detail .description {
            color: #7d7d7d;
            font-size: 1rem;
        }

        .detail .price {
            font-size: 1.5rem;
        }

        .quantity, .remove {
            width: 50%;
            text-align: center;
        }

        .remove svg {
            width: 60px;
            height: 60px;
        }

        .quantity > input {
            border-radius: 10px;
            display: inline-block;
            width: 60px;
            height: 60px;
            position: relative;
            left: calc(50% - 30px);
            background: #fff;
            border: 2px solid #ddd;
            color: #7f7f7f;
            text-align: center;
            font: 600 1.3rem Helvetica, Arial, sans-serif;
        }

        .quantity > input:hover, .quantity > input:focus {
            border-color: #4187d2;
        }

        .summary {
            font-size: 1.2rem;
            text-align: right;
        }

        .summary ul li {
            padding: 0.5rem 0;
        }

        .summary ul li span {
            display: inline-block;
            width: 30%;
        }

        .summary ul li.total {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .checkout {
            text-align: right;
        }

        .checkout > button {
            font-size: 1.2rem;
            padding: 0.8rem 2.8rem;
            border-radius: 1.5rem;
        }

    </style>
@endsection

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('costs.index') }}">Despesas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nova Despesa</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="card col-md-10">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Nova Despesa</span>
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
                    {{--Descricao--}}
                    <div class="col-md-5 mb-2">
                        <div class="form-group">
                            {{ Form::label('description','Descricão') }}
                            {{ Form::text('description', null, ['class' => 'form-control', 'v-model' => 'description', 'required' => 'true']) }}
                            <small>Opcional</small>
                        </div>
                    </div>
                    {{--Fornecedor--}}
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            {{ Form::label('provider_id','Fornecedor') }}
                        </div>
                        <div class="form-group">
                            <select class="form-select" v-model="provider" required>
                                <option :value="null" disabled>Selecione</option>
                                <option v-for="provider in providers" :value="provider">
                                    @{{ provider.name }}
                                </option>
                            </select>
                        </div>
                        <small>Opcional</small>
                    </div>
                    {{--Valor--}}
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            {{ Form::label('amount','Valor') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                <input id="amount" class="form-control mask-money" @focusout="amountFocusout" v-model="amount" required>
                            </div>
                            <small>Valor da despesa (obrigatório)</small>
                        </div>
                    </div>
                    {{--Date Competence--}}
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            {{ Form::label('date','Data de Competência') }}
                            {{ Form::date('date', date('Y-m-d'), ['class' => 'form-control', 'v-model' => 'date', 'required' => 'true']) }}
                            <small>Data em que a desepesa ocorreu (obrigatório)</small>
                        </div>
                    </div>
                    {{--Date Vencimento--}}
                    <div class="col-md-3 mb-2">
                        <div class="form-group">
                            {{ Form::label('date_due','Data de Vencimento') }}
                            {{ Form::date('date_due', date('Y-m-d'), ['class' => 'form-control', 'v-model' => 'date_due', 'required' => 'true']) }}
                        </div>
                        <small>Data de vencimento da desepesa (obrigatório)</small>
                    </div>
                    <hr>
                    {{--Aba de Pagamento--}}
                    <div class="col-md-12 mb-2">
                        {{--Check Pagamento--}}
                        <div class="form-group">
                            <input type="checkbox" id="checkbox" v-model="checked">
                            {{ Form::label('paid','Pago') }}
                        </div>
                        {{--Date Pagamento--}}
                        <div class="row col-md-12 mt-2 mb-2">
                            {{--Tipo Pagamento--}}
                            <div class="form-group col-md-6">
                                {{ Form::label('payment_type','Tipo de pagamento') }}
                                <select class="form-select" id="paymentType" name="paymentType" v-model="paymentType" :required="true" :disabled="checked == false">
                                    <option :value="null" disabled>Selecione</option>
                                    <option v-for="payment in payments" v-bind:value="payment.value">
                                        @{{ payment.text }}
                                    </option>
                                </select>
                                <small>Obrigatório</small>
                            </div>
                            <div class="form-group  col-md-6">
                                {{ Form::label('date_paid','Data de pagamento') }}
                                {{ Form::date('date_paid', null, ['class' => 'form-control', 'v-model' => 'date_paid', ':readonly' => "checked == false", ":required" => "checked == true"]) }}
                            </div>
                        </div>
                    </div>
                    {{--Insumos--}}
                    <div v-if="provider != null" class="col-md-12 mb-2">
                        <div class="form-group">
                            {{ Form::label('feedstocks','Itens da Despesa (opcional)') }}
                        </div>
                        <ul class="feedstocks text-center d-flex flex-column justify-content-between">
                            <div class="row">
                                <li class=" col-md-4" v-for="(feedstock, index) in feedstocks">
                                    <div class="detail d-flex align-items-center justify-content-end mt-4">
                                        <div class="name"><a href="#" style="text-decoration: none;color: #333333;">@{{ feedstock.name }}</a></div>
                                        <div class="quantity">
                                            <input type="number" class="quantity" step="1" @input="updateQuantity(index, $event)" @blur="checkQuantity(index, $event)" placeholder="0"/>
                                        </div>
                                    </div>
                                    <hr>
                                </li>
                            </div>
                        </ul>
                    </div>
                    {{--Finalizar--}}
                    <div class="col-md-12">
                        <button class="btn btn-primary" style="width: 100%" v-on:click="submit()">
                            Finalizar
                        </button>
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
                providers: @json($providers),
                feedstocks: @json($feedstocks),
                provider: null,
                checkedFeedstocks: [],
                amount: "",
                date: null,
                date_due: null,
                date_paid: null,
                payments: [
                    {text: 'Cartão', value: 'CARTAO'},
                    {text: 'Pix', value: 'PIX'},
                    {text: 'Dinheiro', value: 'DINHEIRO'}
                ],
                paymentType: null,
                description: '',
                checked: false
            },
            watch: {
            },
            created() {
                var tzoffset        = (new Date()).getTimezoneOffset() * 60000; //offset in milliseconds
                var localISOTime    = (new Date(Date.now() - tzoffset)).toISOString().slice(0, -1);
                this.date           = localISOTime.slice(0,10);
                this.date_due       = localISOTime.slice(0,10);

                for (var i = 0; i < this.feedstocks.length; i++) {
                    this.feedstocks[i].quantity = 0;
                }
            },
            mounted() {
                $('.mask-money').mask('000.000.000.000,00', {reverse: true, placeholder: '0.00'});
            },
            computed: {
                itemCount: function () {
                    var count = 0;

                    for (var i = 0; i < this.feedstocks.length; i++) {
                        count += parseInt(this.feedstocks[i].quantity) || 0;
                    }

                    return count;
                },
                subTotal: function () {
                    var subTotal = 0;

                    for (var i = 0; i < this.feedstocks.length; i++) {
                        subTotal += this.feedstocks[i].quantity * this.feedstocks[i].price;
                    }

                    return subTotal;
                },
                totalPrice: function () {
                    return this.subTotal;
                }
            },
            filters: {
                currencyFormatted: function (value) {
                    return Number(value).toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }
            },
            methods: {
                amountFocusout(e) {
                    console.log('focusout', e)
                    this.amount = this.amount.replace(/,/g, '');
                    this.amount = this.formatReal(this.amount);
                },
                submit() {

                    if (app.amount == null || app.amount == '') {
                        alert('É necessário informar valor da despesa');
                        return true;
                    }

                    const data = {
                        feedstocks: app.feedstocks,
                        provider: app.provider,
                        amount: app.amount,
                        date: app.date,
                        date_due: app.date_due,
                        date_paid: app.date_paid,
                        paymentType: app.paymentType,
                        description: app.description
                    }
                    console.log(data);
                    console.log('submit');
                    axios.post('{{ route('costs.store') }}', data).then(function (response) {
                        window.location.href = '/costs';
                    });
                },
                updateQuantity: function (index, event) {
                    var value = event.target.value;
                    var feedstock = this.feedstocks[index];

                    if (value === "" || (parseInt(value) > 0 && parseInt(value) < 100)) {
                        feedstock.quantity = value;
                    }

                    this.$set(this.feedstocks, index, feedstock);
                },
                checkQuantity: function (index, event) {
                    if (event.target.value === "") {
                        var feedstock = this.feedstocks[index];
                        feedstock.quantity = 1;
                        this.$set(this.feedstocks, index, feedstock);
                    }
                },
                removeItem: function (index) {
                    this.feedstocks.splice(index, 1);
                },
                formatReal(int) {
                    var tmp = int + '';
                    tmp = tmp.replace(/([0-9]{2})$/g, ",$1");
                    if (tmp.length > 6)
                        tmp = tmp.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$1,$2");

                    return tmp;
                },
            }
        })

    </script>

@endsection
