@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('orders.index') }}>Pedidos</a></li>
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
                    <strong>Cliente</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('customer_id','ID') }}
                            {{ Form::text('customer_id', $order->customer_id, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            {{ Form::label('name','Nome') }}
                            {{ Form::text('name', $order->customer->name, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-4">
                            {{ Form::label('phone','Celular') }}
                            {{ Form::text('phone', $order->customer->phone, ['class' => 'form-control phone', 'readonly']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>Venda número #{{ $order->id }}</strong>
                    <span class="badge bg-info">{{ $order->status_delivery }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('price','Valor') }}
                            {{ Form::text('price', 'R$ ' . \App\Helpers\showCentsValue($order->price), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('delivery_fee','Tx Entrega') }}
                            {{ Form::text('delivery_fee', 'R$ ' . \App\Helpers\showCentsValue($order->delivery_fee), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('discount','Desconto') }}
                            {{ Form::text('discount', 'R$ ' . \App\Helpers\showCentsValue($order->discount), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('total_amount','Total da compra') }}
                            {{ Form::text('total_amount', 'R$ ' . number_format($order->total_amount / 100, 2, ','), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('payment_type','Tipo de pagamento') }}
                            {{ Form::text('payment_type', $order->payment_type, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('delivery_date','Data de registro') }}
                            {{ Form::text('delivery_date', \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('delivery_date','Data de entrega') }}
                            {{ Form::text('delivery_date', \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                </div>

                <table class="table table-bordered">
                    <tr>
                        <td colspan="4">
                            <strong>Itens da compra</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>Tipo</td>
                        <td>Nome</td>
                        <td class="text-center">Qtd</td>
                        <td class="text-end">Preço</td>
                        <td class="text-end">Sub-total</td>
                    </tr>
                    @foreach($order->products as $orderProduct)
                        <tr>
                            <td>PRODUTO</td>
                            <td>{{ $orderProduct->product->description }}</td>
                            <td class="text-center">{{ $orderProduct->quantity }}</td>
                            <td class="text-end">R$ {{ \App\Helpers\showCentsValue($orderProduct->price) }}</td>
                            <td class="text-end">R$ {{ \App\Helpers\showCentsValue($orderProduct->total) }}</td>
                        </tr>
                    @endforeach
                    @foreach($order->aditionals as $orderAditional)
                        <tr>
                            <td>ADICIONAL</td>
                            <td>{{ $orderAditional->aditional->description }}</td>
                            <td class="text-center">{{ $orderAditional->quantity }}</td>
                            <td class="text-end">R$ {{ \App\Helpers\showCentsValue($orderAditional->price) }}</td>
                            <td class="text-end">R$ {{ \App\Helpers\showCentsValue($orderAditional->total) }}</td>
                        </tr>
                    @endforeach
                    <tr class="bg-light">
                        <td class="text-end" colspan="5"><strong class="text-dark">Valor da venda: R$ {{ \App\Helpers\showCentsValue($order->price) }}</strong></td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end" colspan="5"><strong class="text-danger">Total de desconto: R$ {{ \App\Helpers\showCentsValue($order->discount) }}</strong></td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end" colspan="5"><strong class="text-success">Total da venda: R$ {{ number_format($order->total_amount / 100, 2, ',') }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
