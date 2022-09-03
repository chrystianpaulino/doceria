@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Insumos</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Insumos</span>
                <a href="{{ route('feedstocks.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Insumo</a>
            </div>
            <div class="table-responsive table-hover p-2">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td class="text-center">Nome</td>
                            <td class="text-center">Valor</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($feedstocks as $feedstock)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('feedstocks.show', $feedstock->id) }}">
                            <td>
                                <code>#{{ $feedstock->id }}</code>
                            </td>
                            <td class="text-center">
                                {{ $feedstock->name }}
                            </td>
                            <td class="text-center">
                                R$ {{ \App\Helpers\showCentsValue($feedstock->price) }}
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
