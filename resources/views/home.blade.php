@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Início</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mb-3">
                <div class="card mb-3 p-4">
                    <h5 class="card-title">Pedidos de Hoje</h5>
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
                                        <div class="col-12 d-flex flex-row mb-2">
                                            <div class="text-center">
                                                <span class="badge bg-info"> {{ $order->status_payment }}</span>
                                                @if($order->status == 'DELIVERED')
                                                    <span class="badge bg-info">PEDIDO ENTREGUE</span>
                                                @else
                                                    <span class="badge bg-info">ENTREGA PENDENTE</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="col-9">
                                                @if($order->customer)
                                                    <div class="d-flex align-items-center">
                                                        <strong class="me-2">{{ $order->customer->first_name  }} </strong> <span class="badge bg-success"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
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
                                            <div class=""></div>
                                            <div class="col-3 d-flex flex-column align-items-center">
                                                <a href="{{ route('orders.show', $order->id) }}" title="Visualizar pedido" class="btn btn-sm btn-outline-primary button-home mb-2"> <i class="fa-solid fa-eye"></i> Visualizar</a>
                                                @if($order->status != 'DELIVERED')
                                                    <a href="{{ route('orders.delivered', $order->id) }}" title="Marcar pedido como entregue" class="btn btn-sm btn-outline-dark button-home mb-2"><i class="far fa-hand-holding-box"></i> Entregue</a>
                                                @endif
                                                @if($order->getMissing() != '0,00' or $order->getMissing() == null)
                                                    <a href="{{ route('orders.paid', $order->id) }}" title="Pago totalmente" class="btn btn-sm btn-outline-success button-home mb-2"> <i class="fas fa-money-bill-wave"></i> Pago</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                            </div>
                        @endforeach
                    @else
                        <a href="#" type="button" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span>Não há pedidos para hoje</span>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="list-group mb-4">
                    <button type="button" class="list-group-item list-group-item-action active">
                        Pedidos de Amanhã
                    </button>
                    @if(count($ordersTomorrow) > 0)
                        @foreach($ordersTomorrow as $order)
                            <div class="list-group-item list-group-item-action">
                                <div class="card">
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
                                        <div class="col-12 d-flex flex-row mb-4">
                                            <div class="text-center">
                                                <span class="badge bg-info"> {{ $order->status_payment }}</span>
                                                @if($order->status == 'DELIVERED')
                                                    <span class="badge bg-info">PEDIDO ENTREGUE</span>
                                                @else
                                                    <span class="badge bg-info">ENTREGA PENDENTE</span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="col-9">
                                                @if($order->customer)
                                                    <div class="d-flex align-items-center">
                                                        <strong class="me-2">{{ $order->customer->first_name  }} </strong> <span class="badge bg-success"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
                                                    </div>
                                                    <span class="phone">{{ $order->customer->phone }}</span> <br>
                                                    <span>{{ $order->customer->street ? $order->customer->street . ", " : '' }}{{ $order->customer->street_number }}</span> <br>
                                                @else
                                                    <div class="d-flex align-items-center">
                                                        <span class="badge bg-success"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
                                                    </div>
                                                @endif
                                                <span>{{ $order->obs }}</span>
                                            </div>
                                            <div class="col-3 d-flex flex-column align-items-center">
                                                <a href="{{ route('orders.show', $order->id) }}" title="Visualizar pedido" class="btn btn-sm btn-outline-primary button-home mb-2"> <i class="fa-solid fa-eye"></i> Visualizar</a>
                                                @if($order->status != 'DELIVERED')
                                                    <a href="{{ route('orders.delivered', $order->id) }}" title="Marcar pedido como entregue" class="btn btn-sm btn-outline-dark button-home mb-2"><i class="far fa-hand-holding-box"></i> Entregue</a>
                                                @endif
                                                @if($order->getMissing() != '0,00' or $order->getMissing() == null)
                                                    <a href="{{ route('orders.paid', $order->id) }}" title="Pago totalmente" class="btn btn-sm btn-outline-success button-home mb-2"> <i class="fas fa-money-bill-wave"></i> Pago</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <a href="#" type="button" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span>Não há pedidos para amanhã</span>
                                </div>
                            </div>
                        </a>
                    @endif
                </div>
            </div>
            {{--<div class="col-md-4 mb-4">
                <a href="{{ route('orders.create') }}" style="width: 100%" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Pedido</a>
            </div>--}}
        </div>
    </div>
@endsection

