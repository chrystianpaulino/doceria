@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href={{ route('orders.index') }}>Vendas</a></li>
                <li class="breadcrumb-item"><a href={{ route('orders.show', $order->id) }}> Venda #{{ $order->id }}</a></li>
                <li class="breadcrumb-item active" aria-current="page"> Editar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="col-md-12">
            {{ Form::model($order,['route' => ['orders.update', $order->id], 'method' => 'PUT', 'class' => 'needs-validation']) }}
                <div class="col-md-12 text-end d-flex justify-content-end align-items-center mb-2">
                    <a class="btn btn-sm btn-outline-dark me-2" href={{ route('orders.show', $order->id) }}> Cancelar</a>
                    <button class=" btn btn-sm btn-primary text-white" type="submit"><i class="fa fa-refresh" aria-hidden="true"></i> Atualizar Venda</button>
                </div>
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Cliente</span>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group mb-3 col-md-2">
                                {{ Form::label('customer_id','Número') }}
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
                        <span>Venda #{{ $order->id }}</span>
                        <div>
                            <span class="badge bg-info"> {{ $order->status_delivery }}</span>
                            @if($order->status_payment == 'PAGAMENTO PENDENTE')
                                <span class="badge bg-danger"> {{ $order->status_payment }}</span>
                            @else
                                <span class="badge bg-success"> {{ $order->status_payment }}</span>
                            @endif
                        </div>
                    </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('price','Valor') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('price', \App\Helpers\showCentsValue($order->price), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('delivery_fee','Tx Entrega') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('delivery_fee', \App\Helpers\showCentsValue($order->delivery_fee), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('discount','Desconto') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('discount', \App\Helpers\showCentsValue($order->discount), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('total_amount','Total da compra') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('total_amount', number_format($order->total_amount / 100, 2, ','), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('payment_advance','Total já pago') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                @if($order->status_payment == 'PAGAMENTO PENDENTE')
                                    {{ Form::text('payment_advance', $order->payment_advance, ['class' => 'form-control money']) }}
                                @else
                                    {{ Form::text('payment_advance', $order->payment_advance, ['class' => 'form-control money', 'readonly']) }}
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('get_missing','Faltando receber') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('get_missing', $order->getMissing(), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('payment_type','Tipo de pagamento') }}
                            {{ Form::text('payment_type', $order->payment_type, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('delivery_date','Data de registro') }}
                            {{ Form::text('delivery_date', \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i'), ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('delivery_date','Data de entrega') }}
                            {{ Form::date('delivery_date', \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d'), ['class' => 'form-control']) }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group mb-3 col-md-12">
                            {{ Form::label('obs','Observacões') }}
                            {{ Form::textarea('obs', $order->obs, ['class' => 'form-control', 'readonly', 'rows' => '2']) }}
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
                        <td class="text-end" style="font-size: 16px" colspan="5"><strong class="text-info">Total da venda: R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</strong></td>
                    </tr>
                </table>
            </div>
            {{ Form::close() }}
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
    <script>
        $('.money').mask('000.000.000.000.000,00', {reverse: true});
    </script>

@endsection
