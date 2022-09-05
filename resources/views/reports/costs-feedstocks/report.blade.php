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
                Relatório de Insumos
            </div>
            @if(isset($dateTo) and isset($dateFrom))
                <div class="text-center bg-secondary">
                    <strong class="text-white">INTERVALO: {{\Carbon\Carbon::parse($dateFrom)->format('d/m/Y')}} à {{\Carbon\Carbon::parse($dateTo)->format('d/m/Y')}}</strong>
                </div>
            @endif
            @if(isset($feedstockId))
                <div class="text-center bg-secondary">
                    <strong class="text-white">INSUMO SELECIONADO: {{ $costsFeedstocks->first()->feedstock->name }}</strong>
                </div>
            @endif
            @foreach($costsFeedstocks->groupBy('feedstock_id') as $itens)
                <h5 class="p-2 text-center">
                    {{ $itens->first()->feedstock->name }}
                </h5>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Despesa ID</td>
                            <td>Fornecedor</td>
                            <td>Insumo</td>
                            <td>Data</td>
                            <td class="text-center">Quantidade</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itens as $insumo)
                            <tr class="align-middle">
                                <td>
                                    <code>#{{ $insumo->id }}</code>
                                </td>
                                <td>
                                    <code>#{{ $insumo->cost_id }}</code>
                                </td>
                                <td>
                                     {{ $insumo->cost->provider->name }}
                                </td>
                                <td>
                                    {{ $insumo->feedstock->name }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($insumo->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="text-center">
                                    {{ $insumo->quantity }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-right"><strong></strong></td>
                            <td class="text-center"><strong>Total: {{ $itens->sum('quantity') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>

@endsection


@section('js')
    <script src="{{ asset('js/jquery.mask.min.js') }}"></script>

    <script>

        $('.date').mask('00/00/0000');

    </script>
@endsection
