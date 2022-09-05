@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Bem-vindo, {{ session('franchise_name') }}</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {{--Pedidos do dia--}}
            <div class="col-md-6 mb-3">
                <div class="card mb-3 p-4">
                    <h5 class="card-title">Pedidos do dia</h5>
                    @if(count($ordersToday) > 0)
                        @foreach($ordersToday as $order)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="text-start">
                                        <code>Pedido #{{ $order->id }}</code>
                                        @if($order->type == 'CASHIER')
                                            <span class="badge bg-secondary">NO CAIXA</span>
                                        @else
                                            <span class="badge bg-secondary">ENCOMENDA</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12 d-flex flex-row mb-2">
                                        <div class="text-center">
                                            <span class="badge bg-info"> {{ $order->status_payment }}</span>
                                            @if($order->status == 'DELIVERED')
                                                <span class="badge bg-info">PEDIDO ENTREGUE</span>
                                            @else
                                                <span class="badge bg-info">ENTREGA PENDENTE</span>
                                            @endif
                                        </div>
                                    </div>
                                        <div class="row mb-2 col-md-12">
                                            @if($order->customer)
                                                <div class="d-flex align-items-center">
                                                    <strong class="me-2">{{ $order->customer->first_name  }} </strong>
                                                    <span class="badge bg-secondary me-2"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span>
                                                    <span class="badge bg-danger"> {{ $order->getMissing() == '0,00' ? "R$ " . $order->getMissing() : $order->getMissing() }}</span> <br>
                                                </div>
                                                <span class="phone">{{ $order->customer->phone }}</span> <br>
                                                <span>{{ $order->customer->street ? $order->customer->street . ", " : '' }}{{ $order->customer->street_number }}</span>
                                            @else
                                                <div class="d-flex align-items-center">
                                                    <span class="badge bg-success"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
                                                </div>
                                            @endif
                                            <span>{{ $order->obs }}</span>
                                        </div>
                                        <div class="d-flex flex-row">
                                            <div class="me-2">
                                                <a href="{{ route('orders.show', $order->id) }}" title="Visualizar pedido" class="btn btn-sm btn-outline-primary button-home mb-2"> <i class="fa-solid fa-eye"></i> Visualizar</a>
                                            </div>
                                            <div class="me-2">
                                                @if($order->status != 'DELIVERED')
                                                    <a href="{{ route('orders.delivered', $order->id) }}" title="Marcar pedido como entregue" class="btn btn-sm btn-outline-dark button-home mb-2"><i class="far fa-hand-holding-box"></i> Entregue</a>
                                                @endif
                                            </div>
                                            <div>
                                                @if($order->getMissing() != '0,00' or $order->getMissing() == null)
                                                    <a href="{{ route('orders.paid', $order->id) }}" title="Pago totalmente" class="btn btn-sm btn-outline-success button-home mb-2"> <i class="fas fa-money-bill-wave"></i> Pago</a>
                                                @endif
                                            </div>
                                        </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Não há pedidos para hoje</h6>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            {{--Pedidos amanhã--}}
            <div class="col-md-6 mb-3">
                <div class="card mb-3 p-4">
                    <h5 class="card-title">Pedidos para amanhã</h5>
                    @if(count($ordersTomorrow) > 0)
                        @foreach($ordersTomorrow as $order)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <div class="text-start">
                                        <code>Pedido #{{ $order->id }}</code>
                                        @if($order->type == 'CASHIER')
                                            <span class="badge bg-secondary">NO CAIXA</span>
                                        @else
                                            <span class="badge bg-secondary">ENCOMENDA</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="col-md-12 d-flex flex-row mb-2">
                                        <div class="text-center">
                                            <span class="badge bg-info"> {{ $order->status_payment }}</span>
                                            @if($order->status == 'DELIVERED')
                                                <span class="badge bg-info">PEDIDO ENTREGUE</span>
                                            @else
                                                <span class="badge bg-info">ENTREGA PENDENTE</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row mb-2 col-md-12">
                                        @if($order->customer)
                                            <div class="d-flex align-items-center">
                                                <strong class="me-2">{{ $order->customer->first_name  }} </strong>
                                                <span class="badge bg-secondary me-2"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span>
                                                <span class="badge bg-danger"> {{ $order->getMissing() != '0,00' ? "R$ " . $order->getMissing() : $order->getMissing() }}</span> <br>
                                            </div>
                                            <span class="phone">{{ $order->customer->phone }}</span> <br>
                                            <span>{{ $order->customer->street ? $order->customer->street . ", " : '' }}{{ $order->customer->street_number }}</span>
                                        @else
                                            <div class="d-flex align-items-center">
                                                <span class="badge bg-success"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
                                            </div>
                                        @endif
                                        <span>{{ $order->obs }}</span>
                                    </div>
                                    <div class="d-flex flex-row col-md-12">
                                        <div class="me-2">
                                            <a href="{{ route('orders.show', $order->id) }}" title="Visualizar pedido" class="btn btn-sm btn-outline-primary button-home mb-2"> <i class="fa-solid fa-eye"></i> Visualizar</a>
                                        </div>
                                        <div class="me-2">
                                            @if($order->status != 'DELIVERED')
                                                <a href="{{ route('orders.delivered', $order->id) }}" title="Marcar pedido como entregue" class="btn btn-sm btn-outline-dark button-home mb-2"><i class="far fa-hand-holding-box"></i> Entregue</a>
                                            @endif
                                        </div>
                                        <div>
                                            @if($order->getMissing() != '0,00' or $order->getMissing() == null)
                                                <a href="{{ route('orders.paid', $order->id) }}" title="Pago totalmente" class="btn btn-sm btn-outline-success button-home mb-2"> <i class="fas fa-money-bill-wave"></i> Pago</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="card-subtitle mb-2 text-muted">Não há pedidos para hoje</h6>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

