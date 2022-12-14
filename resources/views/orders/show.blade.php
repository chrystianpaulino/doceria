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
            <div class="col-md-12 text-end d-flex justify-content-end align-items-center mb-2">
                <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-sm btn-primary"><i class="fas fa-pencil"></i> Editar Pedido</a>
            </div>
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Cliente</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group mb-3 col-1">
                            {{ Form::label('customer_id','ID') }}
                            {{ Form::text('customer_id', $order->customer_id, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('name','Nome') }}
                            {{ Form::text('name', $order->customer->name, ['class' => 'form-control', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('phone','Celular') }}
                            {{ Form::text('phone', $order->customer->phone, ['class' => 'form-control phone', 'readonly']) }}
                        </div>
                        <div class="form-group mb-3 col-md-6">
                            {{ Form::label('street','Endereco') }}
                            {{ Form::text('street', $order->customer->street . ", " . $order->customer->street_number . ". " .$order->customer->city . ". " .$order->customer->neighborhood, ['class' => 'form-control', 'readonly']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Pedido #{{ $order->id }}</span>
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
                                {{ Form::text('discount', 'R$ ' . \App\Helpers\showCentsValue($order->discount), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('total_amount','Total') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('total_amount', 'R$ ' . number_format($order->total_amount / 100, 2, ','), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('payment_advance','Total já pago') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('payment_advance', 'R$ ' . number_format($order->payment_advance / 100, 2, ','), ['class' => 'form-control', 'readonly']) }}
                            </div>
                        </div>
                        <div class="form-group mb-3 col-md-2">
                            {{ Form::label('get_missing','Faltando receber') }}
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon1">R$</span>
                                {{ Form::text('get_missing', $order->getMissing(), ['class' => 'form-control', 'readonly']) }}
                            </div>
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
                        <div class="form-group mb-3 col-md-3">
                            {{ Form::label('status','Status do Pedido') }}
                            {{ Form::select('status', ['PENDING' => 'Pendente', 'DELIVERED' => 'Entregue'], $order->status, ['class' => 'form-control', 'readonly']) }}
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
                            <span>Itens do Pedido</span>
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
                        <td class="text-end" colspan="5"><strong class="text-dark">Valor do Pedido: R$ {{ \App\Helpers\showCentsValue($order->price) }}</strong></td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end" colspan="5"><strong class="text-dark">Valor da Entrega: R$ {{ \App\Helpers\showCentsValue($order->delivery_fee) }}</strong></td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end" colspan="5"><strong class="text-danger">Total de Desconto: R$ {{ \App\Helpers\showCentsValue($order->discount) }}</strong></td>
                    </tr>
                    <tr class="bg-light">
                        <td class="text-end" style="font-size: 16px" colspan="5"><strong class="text-info">Total do Pedido: R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

@endsection
