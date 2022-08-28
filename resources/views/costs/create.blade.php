@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('costs.index') }}">Gastos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Novo Gasto</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="card col-md-10">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Novo Gasto</strong>
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
                    <div class="col-md-6 mb-4">
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
                    </div>
                    <div class="col-md-6 mb-4">
                        <div class="form-group">
                            {{ Form::label('amount','Valor') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('amount', null, ['class' => 'form-control', 'v-model' => 'amount']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mb-4">
                        <div class="form-group">
                            {{ Form::label('feedstocks','Produtos') }}
                        </div>
                        <ul class="feedstocks">
                            <li class="row" v-for="(feedstock, index) in feedstocks">
                                <div class="col left">
                                    <div class="detail">
                                        <div class="name"><a href="#">@{{ feedstock.name }}</a></div>
                                        <div class="price">@{{ feedstock.price | currencyFormatted }}</div>
                                    </div>
                                </div>
                                <div class="col right">
                                    <div class="quantity">
                                        <input type="number" class="quantity" step="1" @input="updateQuantity(index, $event)" @blur="checkQuantity(index, $event)" placeholder="0" />
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
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
                amount: ""
            },
            watch: {},
            created() {
                for (var i = 0; i < this.feedstocks.length; i++) {
                    this.feedstocks[i].quantity = 0;
                }
            },
            mounted() {
                //
            },
            computed: {
                itemCount: function() {
                    var count = 0;

                    for (var i = 0; i < this.feedstocks.length; i++) {
                        count += parseInt(this.feedstocks[i].quantity) || 0;
                    }

                    return count;
                },
                subTotal: function() {
                    var subTotal = 0;

                    for (var i = 0; i < this.feedstocks.length; i++) {
                        subTotal += this.feedstocks[i].quantity * this.feedstocks[i].price;
                    }

                    return subTotal;
                },
                totalPrice: function() {
                    return this.subTotal;
                }
            },
            filters: {
                currencyFormatted: function(value) {
                    return Number(value).toLocaleString('pt-BR', {
                        style: 'currency',
                        currency: 'BRL'
                    });
                }
            },
            methods: {
                submit() {
                    const data = {
                        feedstocks: app.feedstocks,
                        provider: app.provider,
                        amount: app.amount,
                    }
                    console.log(data);
                    console.log('submit');
                    axios.post('{{ route('costs.store') }}', data).then(function (response) {
                        window.location.href = '/costs';
                    });
                },
                updateQuantity: function(index, event) {
                    var value = event.target.value;
                    var feedstock = this.feedstocks[index];

                    // Minimum quantity is 1, maximum quantity is 100, can left blank to input easily
                    if (value === "" || (parseInt(value) > 0 && parseInt(value) < 100)) {
                        feedstock.quantity = value;
                    }

                    this.$set(this.feedstocks, index, feedstock);
                },
                checkQuantity: function(index, event) {
                    // Update quantity to 1 if it is empty
                    if (event.target.value === "") {
                        var feedstock = this.feedstocks[index];
                        feedstock.quantity = 1;
                        this.$set(this.feedstocks, index, feedstock);
                    }
                },
                removeItem: function(index) {
                    this.feedstocks.splice(index, 1);
                },
                checkPromoCode: function() {
                    for (var i = 0; i < this.promotions.length; i++) {
                        if (this.promoCode === this.promotions[i].code) {
                            this.discount = parseFloat(
                                this.promotions[i].discount.replace("%", "")
                            );
                            return;
                        }
                    }

                    alert("Sorry, the Promotional code you entered is not valid!");
                }
            }
        })

    </script>

@endsection
