@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Custos</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Gastos</strong>
                <a href="{{ route('costs.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Gasto</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($costs as $cost)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('costs.show', $cost->id) }}">
                            <td>
                                <code>#{{ $cost->id }}</code>
                            </td>
                            <td class="text-center">
                                {{ $cost->provider->name }}
                            </td>
                            <td class="text-center">
                                {{ $cost->provider->phone }}
                            </td>
                            <td class="text-center">
                                R$ {{ \App\Helpers\showCentsValue($cost->amount) }}
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
