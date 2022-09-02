@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('costs.index') }}>Custos</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Visualizar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Fornecedor</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('customer_id','ID') }}
                            {{ Form::text('customer_id', $cost->id, ['class' => 'form-control', 'readonly']) }}
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

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Custo número #{{ $cost->id }}</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('price','Valor') }}
                            {{ Form::text('price', 'R$ ' . \App\Helpers\showCentsValue($cost->amount), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('payment_type','Tipo de pagamento') }}
                            {{ Form::text('payment_type', $cost->payment_type, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('delivery_date','Data da despesa') }}
                            {{ Form::text('delivery_date', \Carbon\Carbon::parse($cost->date_cost)->format('d/m/Y'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('delivery_date','Registrado em') }}
                            {{ Form::text('delivery_date', \Carbon\Carbon::parse($cost->created_at)->format('d/m/Y H:i'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                </div>

                @if($cost->feedstocks)
                    <table class="table table-bordered">
                        @if(count($cost->feedstocks) > 0)
                            <tr>
                                <td colspan="4">
                                    <strong>Itens da despesa</strong>
                                </td>
                            </tr>
                            <tr>
                                <td>Tipo</td>
                                <td>Nome</td>
                                <td class="text-center">Qtd</td>
                            </tr>
                            @foreach($cost->feedstocks as $costFeedstock)
                                <tr>
                                    <td>INSUMO</td>
                                    <td>{{ $costFeedstock->feedstock->name }}</td>
                                    <td class="text-center">{{ $costFeedstock->quantity }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr class="text-end">
                                <td>Não foram inseridos insumos para este gasto</td>
                            </tr>
                        @endif
                        <tr class="bg-light">
                            <td class="text-end" style="font-size: 16px" colspan="5"><strong class="text-info">Total da despesa: R$ {{ \App\Helpers\showCentsValue($cost->amount) }}</strong></td>
                        </tr>
                    </table>
                @endif
            </div>
        </div>
    </div>

@endsection
