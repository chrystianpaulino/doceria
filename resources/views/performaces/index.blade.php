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
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Resumo do Mês
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
                                <div class="card-header" style="background-color: transparent">Lucro</div>
                                <div class="card-body">
                                    <h5 class="card-title">R$ {{ \App\Helpers\showCentsValue($totalFaturado - $totalGasto) }}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="canvaDesempenhoPedidosMensal"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Resumo do Ano
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <canvas id="canvaDesempenhoPedidosAnual"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/chartjs.min.js') }}"></script>

    <script>

        window.onload = function() {
            var chartMes = document.getElementById('canvaDesempenhoPedidosMensal').getContext('2d');
            var chartAno = document.getElementById('canvaDesempenhoPedidosAnual').getContext('2d');

            window.myLine = new Chart(chartMes, {
                type: 'line',
                data: {
                    type: 'line',
                    labels: [
                        @foreach($arrayPedidosMes as $pedidosDia)
                             '{{ isset($pedidosDia['diaMes']) ? "Dia " . $pedidosDia['diaMes'] : null }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Qtd. pedidos',
                            backgroundColor: '#6cb2eb',
                            borderColor: '#6cb2eb',
                            data: [
                                @foreach($arrayPedidosMes as $pedidosDia)
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
                        text: 'Desempenho de Pedidos - Mês Atual'
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

            window.myLine = new Chart(chartAno, {
                type: 'line',
                data: {
                    type: 'line',
                    labels: [
                        @foreach($arrayPedidosAno as $pedidosDia)
                            '{{ isset($pedidosDia['diaMes']) ? $pedidosDia['diaMes'] : null }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Qtd. pedidos',
                            backgroundColor: '#8800ff',
                            borderColor: '#8800ff',
                            data: [
                                @foreach($arrayPedidosAno as $pedidosDia)
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
                        text: 'Desempenho de Pedidos - Ano Atual'
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
                                labelString: 'Mês do Ano'
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
