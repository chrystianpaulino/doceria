@extends('layouts.app')

@section('breads')
    <div class="container d-print-none">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item"><a href="{{ route('reports.index') }}">Relatórios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')

    <div class="container d-flex justify-content-center mb-4">
        <div class="card col-md-12">
            <div class="card-header d-flex justify-content-between align-items-center">
                Relatório de Pedidos
            </div>
            @if(isset($dateTo) and isset($dateFrom))
                <div class="text-center bg-secondary">
                    <strong class="text-white">INTERVALO: {{\Carbon\Carbon::parse($dateFrom)->format('d/m/Y')}} à {{\Carbon\Carbon::parse($dateTo)->format('d/m/Y')}}</strong>
                </div>
            @endif
            @if(isset($customerId))
                <div class="text-center bg-secondary">
                    <strong class="text-white">CLIENTE SELECIONADO: {{ $orders->first()->customer->name }}</strong>
                </div>
            @endif
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Cliente</td>
                    <td class="text-center">Valor</td>
                    <td class="text-center">Taxa de Delivery</td>
                    <td class="text-center">Desconto</td>
                    <td class="text-center">Total</td>
                    <td class="text-center">Tipo do Pagamento</td>
                    <td class="text-center">Status Pagamento</td>
                    <td class="text-center">Status Pedido</td>
                    <td class="text-center">Data de Entrega</td>
                    <td class="text-center">Data de Registro</td>
                </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr class="align-middle" onclick="alertMe(this)"
                        data-url="{{ route('orders.show', $order->id) }}">
                        <td>
                            <code>#{{ $order->id }}</code>
                        </td>
                        <td>
                            {{ $order->customer->first_name }}
                        </td>

                        <td class="text-center">
                            R$ {{ \App\Helpers\showCentsValue($order->price) }}
                        </td>
                        <td class="text-center">
                            R$ {{ \App\Helpers\showCentsValue($order->delivery_fee) }}
                        </td>
                        <td class="text-center">
                            R$ {{ \App\Helpers\showCentsValue($order->discount) }}
                        </td>
                        <td class="text-center">
                            R$ {{ \App\Helpers\showCentsValue($order->total_amount) }}
                        </td>
                        <td class="text-center">
                            {{ $order->payment_type }}
                        </td>
                        <td class="text-center">
                            @if($order->status_payment == 'PAGAMENTO PENDENTE')
                                <span class="badge bg-danger"> {{ $order->status_payment }}</span>
                            @else
                                <span class="badge bg-success"> {{ $order->status_payment }}</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($order->status == 'DELIVERED')
                                <span class="badge bg-success">PEDIDO ENTREGUE</span>
                            @else
                                <span class="badge bg-danger">PEDIDO PENDENTE</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class=""> {{ $order->status_delivery }} - {{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y')}}</span>
                        </td>
                        <td class="text-center">
                            <span class=""> {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i')}}</span>
                        </td>
                    </tr>
                @endforeach
                </tbody>
                <tr>
                    <td colspan="11" class="text-end"><strong>TOTAL: R$ {{ number_format(($orders->sum('total_amount')/100),2,',') }}</strong></td>
                </tr>
            </table>
        </div>
    </div>

@endsection


@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script>

        $('.date').mask('00/00/0000');

    </script>
@endsection
