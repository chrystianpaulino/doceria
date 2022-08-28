@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pedidos</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Pedidos</strong>
                <a href="{{ route('orders.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Pedido</a>
            </div>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr class="align-middle" style="font-weight: bold">
                        <td>#Número</td>
                        <td>Cliente</td>
                        <td class="text-center">Preco</td>
                        <td class="text-center">Taxa de Delivery</td>
                        <td class="text-center">Desconto</td>
                        <td class="text-center">Total</td>
                        <td class="text-center">Pagamento</td>
                        <td class="text-center">Status</td>
                        <td class="text-center">Data</td>
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
                                {{ $order->customer->name }}
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
                                {{ $order->status_delivery }}
                            </td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($order->delivery_date)->format('d/m/Y')}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('css')
    <style>
        tr {
            cursor: pointer;
        }
    </style>
@endsection

@section('js')
    <script>
        function alertMe(that) {
            window.location = that.dataset.url;
        }
    </script>
@endsection
