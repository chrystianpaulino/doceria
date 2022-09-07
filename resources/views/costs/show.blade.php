@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('costs.index') }}>Despesas</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Visualizar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="col-md-12">
            @if($cost->provider_id)
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Fornecedor</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mb-3 col-md-2">
                                {{ Form::label('customer_id','ID') }}
                                {{ Form::text('customer_id', $cost->provider->id, ['class' => 'form-control', 'readonly']) }}
                            </div>
                            <div class="form-group mb-3 col-md-6">
                                {{ Form::label('name','Fornecedor') }}
                                {{ Form::text('name', $cost->provider->name, ['class' => 'form-control', 'readonly']) }}
                            </div>
                            <div class="form-group mb-3 col-md-4">
                                {{ Form::label('phone','Celular') }}
                                {{ Form::text('phone', $cost->provider->phone, ['class' => 'form-control phone', 'readonly']) }}
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Despesa #{{ $cost->id }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-1">
                            {{ Form::label('customer_id','ID') }}
                            {{ Form::text('customer_id', $cost->id, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-5">
                            {{ Form::label('description','Descricão') }}
                            {{ Form::text('description', $cost->description, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('price','Valor') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('price', \App\Helpers\showCentsValue($cost->amount), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('delivery_date','Data da competência') }}
                            {{ Form::text('delivery_date', \Carbon\Carbon::parse($cost->date_cost)->format('d/m/Y'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('delivery_date','Registrado em') }}
                            {{ Form::text('delivery_date', \Carbon\Carbon::parse($cost->created_at)->format('d/m/Y H:i'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>

                    <hr>

                    <div class="row d-flex align-items-center">
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('payment_type','Tipo de pagamento') }}
                            {{ Form::text('payment_type', isset($cost->date_paid) ? $cost->payment_type : 'Pagamento Pendente', ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('date_paid','Pago em') }}
                            {{ Form::text('date_paid', isset($cost->date_paid) ? \Carbon\Carbon::parse($cost->date_paid)->format('d/m/Y') : 'Pagamento Pendente', ['class' => 'form-control', 'readonly']) }}
                        </div>
                        @if(!isset($cost->date_paid))
                            <div class=" col-md-2">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Marcar como paga
                                </button>
                            </div>
                        @endif
                    </div>

                </div>

                @if($cost->feedstocks)
                    <table class="table table-bordered">
                        @if(count($cost->feedstocks) > 0)
                            <tr>
                                <td colspan="4">
                                    <span>Itens da Despesa</span>
                                </td>
                            </tr>
                            <tr>
                                <td>Nome</td>
                                <td class="text-center">Qtd</td>
                            </tr>
                            @foreach($cost->feedstocks as $costFeedstock)
                                <tr>
                                    <td>{{ $costFeedstock->feedstock->name }}</td>
                                    <td class="text-center">{{ $costFeedstock->quantity }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-end">
                                <td>Não foram inseridos insumos para essa despesa</td>
                            </tr>
                        @endif
                            <tr class="bg-light">
                                <td class="text-end" style="font-size: 16px" colspan="5"><strong class="text-info">Total da Despesa: R$ {{ \App\Helpers\showCentsValue($cost->amount) }}</strong></td>
                            </tr>
                    </table>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Paid -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Marcar como paga <code>Despesa #{{ $cost->id }}</code></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{ Form::open(['route' => ['costs.paid', $cost->id], 'class' => 'needs-validation']) }}
                    <div class="modal-body">
                        <div class="form-group mb-2">
                            {{ Form::label('payment_type','Tipo de pagamento') }}
                            {{ Form::select('payment_type', ['CARTAO' => 'Cartão', 'PIX' => 'Pix', 'DINHEIRO' => 'Dinheiro'], null, ['class' => 'form-control', 'placeholder' => 'Selecione', 'required']) }}
                        </div>
                        <div class="form-group mb-2">
                            {{ Form::label('date_paid','Pago em') }}
                            {{ Form::date('date_paid', date('Y-m-d'), ['class' => 'form-control', 'required']) }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Confirmar</button>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

@endsection
