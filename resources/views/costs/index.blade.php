@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contas a Pagar</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Despesas</span>
                <a href="{{ route('costs.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Nova Despesa</a>
            </div>
            <div class="table-responsive table-hover p-2">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td class="text-center">Fornecedor</td>
                            <td class="text-center">Pagamento</td>
                            <td class="text-center">Valor</td>
                            <td class="text-center">Data</td>
                            <td class="text-center">Vencimento</td>
                            <td class="text-center">Pagamento</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($costs as $cost)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('costs.show', $cost->id) }}">
                            <td>
                                <code>#{{ $cost->id }}</code>
                            </td>
                            <td class="text-center">
                                {{ isset($cost->provider->name) ? $cost->provider->name : '' }}
                            </td>
                            <td class="text-center">
                                {{ $cost->payment_type ?? '' }}
                            </td>
                            <td class="text-center">
                                R$ {{ \App\Helpers\showCentsValue($cost->amount) }}
                            </td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($cost->date_cost)->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($cost->date_due)->format('d/m/Y') }}
                            </td>
                            <td class="text-center">
                                {{ isset($cost->date_paid) ? \Carbon\Carbon::parse($cost->date_paid)->format('d/m/Y') : 'Pagamento Pendente'}}
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
