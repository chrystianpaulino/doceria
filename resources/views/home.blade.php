@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="list-group mb-4">
                    <button type="button" class="list-group-item list-group-item-action active">
                        Pedidos de Hoje
                    </button>
                    @if(count($ordersToday) > 0)
                        @foreach($ordersToday as $order)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center">
                                            <strong class="me-2">{{ $order->customer->first_name  }} </strong> <span class="badge bg-secondary"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
                                        </div>
                                        <span class="phone">{{ $order->customer->phone }}</span> <br>
                                        <span>{{ $order->customer->street ? $order->customer->street . ", " : '' }}{{ $order->customer->street_number }}</span> <br>
                                    </div>
                                    <div class=""></div>
                                    <div class="col-2 d-flex flex-column align-items-center">
                                        <a href="{{ route('orders.show', $order->id) }}" title="Visualizar pedido" class="btn btn-sm btn-outline-primary mb-2"> <i class="fa-solid fa-eye"></i></a>
                                        @if($order->status != 'DELIVERED')
                                            <a href="{{ route('orders.delivered', $order->id) }}" title="Marcar pedido como entregue" class="btn btn-sm btn-outline-success mb-2"> <i class='fa fa-check'></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="text-center">
                                        @if($order->status_payment == 'PAGAMENTO PENDENTE')
                                            <span class="badge bg-danger"> {{ $order->status_payment }}</span>
                                        @else
                                            <span class="badge bg-success"> {{ $order->status_payment }}</span>
                                        @endif
                                            @if($order->status == 'DELIVERED')
                                                <span class="badge bg-success">PEDIDO ENTREGUE</span>
                                            @else
                                                <span class="badge bg-danger">PEDIDO PENDENTE</span>
                                            @endif
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
                <div class="list-group mb-4">
                    <button type="button" class="list-group-item list-group-item-action active">
                        Pedidos de Amanhã
                    </button>
                    @if(count($ordersTomorrow) > 0)
                        @foreach($ordersTomorrow as $order)
                            <div class="list-group-item list-group-item-action">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="col-9">
                                        <div class="d-flex align-items-center">
                                            <strong class="me-2">{{ $order->customer->first_name  }} </strong> <span class="badge bg-secondary"> R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
                                        </div>
                                        <span class="phone">{{ $order->customer->phone }}</span> <br>
                                        <span>{{ $order->customer->street ? $order->customer->street . ", " : '' }}{{ $order->customer->street_number }}</span> <br>
                                    </div>
                                    <div class=""></div>
                                    <div class="col-2 d-flex flex-column align-items-center">
                                        <a href="{{ route('orders.show', $order->id) }}" title="Visualizar pedido" class="btn btn-sm btn-outline-primary mb-2"> <i class="fa-solid fa-eye"></i></a>
                                        @if($order->status != 'DELIVERED')
                                            <a href="{{ route('orders.delivered', $order->id) }}" title="Marcar pedido como entregue" class="btn btn-sm btn-outline-success mb-2"> <i class='fa fa-check'></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 d-flex flex-row">
                                    <div class="text-center">
                                        @if($order->status_payment == 'PAGAMENTO PENDENTE')
                                            <span class="badge bg-danger"> {{ $order->status_payment }}</span>
                                        @else
                                            <span class="badge bg-success"> {{ $order->status_payment }}</span>
                                        @endif
                                        @if($order->status == 'DELIVERED')
                                            <span class="badge bg-success">PEDIDO ENTREGUE</span>
                                        @else
                                            <span class="badge bg-danger">PEDIDO PENDENTE</span>
                                        @endif
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
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Resumo do mês
                    </div>
                    <div class="card-body">
                        <div class="row text-center justify-content-center align-items-center">
                            <div class="col-md-4 card bg-light mb-3 me-3" style="max-width: 18rem;">
                                <div class="card-header" style="background-color: transparent">Pedidos</div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pedidosTotalMes }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 card bg-light mb-3 me-3" style="max-width: 18rem;">
                                <div class="card-header" style="background-color: transparent">Faturado</div>
                                <div class="card-body">
                                    <h5 class="card-title">R$ {{ \App\Helpers\showCentsValue($totalFaturado) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 card bg-light mb-3 me-3" style="max-width: 18rem;">
                                <div class="card-header" style="background-color: transparent">Gasto</div>
                                <div class="card-body">
                                    <h5 class="card-title">R$ {{ \App\Helpers\showCentsValue($totalGasto) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-4 card bg-light mb-3 me-3" style="max-width: 18rem;">
                                <div class="card-header" style="background-color: transparent">Novos Clientes</div>
                                <div class="card-body">
                                    <h5 class="card-title"> {{ $novosClientes }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="width: 100%;">
                            <canvas id="canvaDesempenhoPedidosMensal"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mt-4">
                    <a href="{{ route('orders.create') }}" style="width: 100%" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Pedido</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/chartjs.min.js') }}"></script>

    <script>

        window.onload = function() {
            var ctx = document.getElementById('canvaDesempenhoPedidosMensal').getContext('2d');
            window.myLine = new Chart(ctx, {
                type: 'line',
                data: {
                    type: 'line',
                    labels: [
                        @foreach($arrayPedidos as $pedidosDia)
                             '{{ isset($pedidosDia['diaMes']) ? "Dia " . $pedidosDia['diaMes'] : null }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Qtd. pedidos',
                            backgroundColor: '#6cb2eb',
                            borderColor: '#6cb2eb',
                            data: [
                                @foreach($arrayPedidos as $pedidosDia)
                                    {{ isset($pedidosDia['pedidos']) ? $pedidosDia['pedidos'] : null }},
                                @endforeach
                            ],
                            fill: false,
                        },
                    ]
                },
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: 'Desempenho de Pedidos'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    hover: {
                        mode: 'nearest',
                        intersect: true
                    },
                    elements: {
                        line: {
                            tension: 0, // disables bezier curves
                        }
                    },
                    scales: {
                        xAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Dia do Mês'
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: true,
                                labelString: 'Pedidos Registrados'
                            }
                        }]
                    }
                }
            });
        };
    </script>


@endsection
