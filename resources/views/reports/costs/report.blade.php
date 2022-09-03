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
                Relatório de Custos
            </div>
            @if(isset($dateTo) and isset($dateFrom))
                <div class="text-center bg-secondary">
                    <strong class="text-white">INTERVALO: {{\Carbon\Carbon::parse($dateFrom)->format('d/m/Y')}} à {{\Carbon\Carbon::parse($dateTo)->format('d/m/Y')}}</strong>
                </div>
            @endif
            @if(isset($customerId))
                <div class="text-center bg-secondary">
                    <strong class="text-white">FORNECEDOR SELECIONADO: {{ $orders->first()->provider->name }}</strong>
                </div>
            @endif
            <table class="table table-hover">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Fornecedor</td>
                    <td class="text-center">Total</td>
                    <td class="text-center">Tipo do Pagamento</td>
                    <td class="text-center">Data da Despesa</td>
                    <td class="text-center">Data de Registro</td>
                </tr>
                </thead>
                <tbody>
                    @foreach($costs as $cost)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('orders.show', $cost->id) }}">
                            <td>
                                <code>#{{ $cost->id }}</code>
                            </td>
                            <td>
                                {{ $cost->provider->name }}
                            </td>

                            <td class="text-center">
                                R$ {{ \App\Helpers\showCentsValue($cost->amount) }}
                            </td>

                            <td class="text-center">
                                {{ $cost->payment_type }}
                            </td>

                            <td class="text-center">
                                <span class=""> {{ \Carbon\Carbon::parse($cost->date_cost)->format('d/m/Y H:i')}}</span>
                            </td>

                            <td class="text-center">
                                <span class=""> {{ \Carbon\Carbon::parse($cost->created_at)->format('d/m/Y H:i')}}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tr>
                    <td colspan="11" class="text-end"><strong>TOTAL: R$ {{ number_format(($costs->sum('amount')/100),2,',') }}</strong></td>
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
