@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="p-4">
        <div class="row justify-content-center">
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        Resumo do Mês
                    </div>
                    <div class="card-body">
                        <div class="row text-center justify-content-center align-items-center">
                            <div class="col-md-4 card bg-light mb-3 me-3" style="max-width: 18rem;">
                                <div class="card-header" style="background-color: transparent">Qtd. Pedidos</div>
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
                                <div class="card-header" style="background-color: transparent">Despesa</div>
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
                            <div class="col-md-6">
                                <canvas id="canvaDesempenhoPedidosMensal"></canvas>
                            </div>
                            <div class="col-md-6">
                                <canvas id="canvaDesempenhoPedidosMensalDois"></canvas>
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
                            <div class="col-md-6">
                                <canvas id="canvaDesempenhoPedidosAnualDois"></canvas>
                            </div>
                            <div class="col-md-6">
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
            var chartMesDois = document.getElementById('canvaDesempenhoPedidosMensalDois').getContext('2d');
            var chartAno = document.getElementById('canvaDesempenhoPedidosAnual').getContext('2d');
            var chartAnoDois = document.getElementById('canvaDesempenhoPedidosAnualDois').getContext('2d');

            window.myLine = new Chart(chartMes, {
                type: 'line',
                data: {
                    type: 'line',
                    labels: [
                        @foreach($arrayPedidosMes as $pedidosDia)
                             '{{ isset($pedidosDia['diaMes']) ?  $pedidosDia['diaMes'] : null }}',
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
                        text: 'Desempenho de Pedidos Diário - Mês Atual'
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

            window.myLine = new Chart(chartMesDois, {
                type: 'line',
                data: {
                    type: 'line',
                    labels: [
                        @foreach($arrayPedidosMes as $pedidosDia)
                            '{{ isset($pedidosDia['diaMes']) ?  $pedidosDia['diaMes'] : null }}',
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: 'Faturado R$',
                            backgroundColor: '#00611d',
                            borderColor: '#00611d',
                            data: [
                                @foreach($arrayPedidosMes as $pedidosDia)
                                {{ isset($pedidosDia['faturado']) ? $pedidosDia['faturado'] : null }},
                                @endforeach
                            ],
                            fill: false,
                        },
                        {
                            label: 'Despesas R$',
                            backgroundColor: '#ff0000',
                            borderColor: '#ff0000',
                            data: [
                                @foreach($arrayPedidosMes as $pedidosDia)
                                {{ isset($pedidosDia['investido']) ? $pedidosDia['investido'] : null }},
                                @endforeach
                            ],
                            fill: false,
                        },
                        {
                            label: 'Lucro R$',
                            backgroundColor: '#0066ff',
                            borderColor: '#0066ff',
                            data: [
                                @foreach($arrayPedidosMes as $pedidosDia)
                                {{ isset($pedidosDia['investido']) ? ($pedidosDia['faturado'] - $pedidosDia['investido']) : null }},
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
                        text: 'Desempenho de Faturamento Diário - Mês Atual'
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
                                labelString: 'Valor R$'
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
                            label: 'Faturado R$',
                            backgroundColor: '#00611d',
                            borderColor: '#00611d',
                            data: [
                                @foreach($arrayPedidosAno as $pedidosDia)
                                {{ isset($pedidosDia['faturado']) ? $pedidosDia['faturado'] : null }},
                                @endforeach
                            ],
                            fill: false,
                        },
                        {
                            label: 'Despesas R$',
                            backgroundColor: '#ff0000',
                            borderColor: '#ff0000',
                            data: [
                                @foreach($arrayPedidosAno as $pedidosDia)
                                {{ isset($pedidosDia['investido']) ? $pedidosDia['investido'] : null }},
                                @endforeach
                            ],
                            fill: false,
                        },
                        {
                            label: 'Lucro R$',
                            backgroundColor: '#0066ff',
                            borderColor: '#0066ff',
                            data: [
                                @foreach($arrayPedidosAno as $pedidosDia)
                                {{ isset($pedidosDia['investido']) ? ($pedidosDia['faturado'] - $pedidosDia['investido']) : null }},
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
                        text: 'Desempenho de Faturamento Mensal - 12 meses'
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
                                labelString: 'Valor R$'
                            }
                        }]
                    }
                }
            });

            window.myLine = new Chart(chartAnoDois, {
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
                        text: 'Desempenho de Pedidos Mensal - 12 meses'
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
                                labelString: 'Valor R$'
                            }
                        }]
                    }
                }
            });
        };
    </script>


@endsection
