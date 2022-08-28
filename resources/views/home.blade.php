@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 mb-4">
                <div class="list-group">
                    <button type="button" class="list-group-item list-group-item-action active">
                        Pedidos de hoje
                    </button>
                    @foreach($ordersToday as $order)
                        <a href="{{ route('orders.show', $order->id) }}" type="button" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span>{{ $order->customer->name }}</span> <br>
                                    <span class="phone">{{ $order->customer->phone }}</span> <br>
                                    <span>R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}</span> <br>
                                    <span class="phone">{{ $order->customer->street ? $order->customer->street . ", " : '' }}{{ $order->customer->street_number }}</span> <br>
                                </div>
                                <div>
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Dashboard
                    </div>
                    <div class="card-body">
                        <div class="row text-center justify-content-center align-items-center">
                            <div class="col-md-3 card bg-light mb-3 me-3" style="max-width: 18rem;">
                                <div class="card-header" style="background-color: transparent">Pedidos</div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $pedidosTotalMes }}</h5>
                                </div>
                            </div>
                            <div class="col-md-3 card bg-light mb-3  me-3" style="max-width: 18rem;">
                                <div class="card-header" style="background-color: transparent">Faturado</div>
                                <div class="card-body">
                                    <h5 class="card-title">R$ {{ \App\Helpers\showCentsValue($totalFaturado) }}</h5>
                                </div>
                            </div>
                            <div class="col-md-3 card bg-light mb-3" style="max-width: 18rem;">
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
                    labels: [
                        @foreach($arrayPedidos as $pedidosDia)
                            {{ isset($pedidosDia['diaMes']) ? $pedidosDia['diaMes'] : null }},
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Pedidos',
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
                                labelString: 'Pedidos Concluídos'
                            }
                        }]
                    }
                }
            });
        };
    </script>


@endsection
