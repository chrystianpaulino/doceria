@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Produtos</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Produtos</span>
                <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Produto</a>
            </div>
            <div class="table-responsive table-hover p-2">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>Status</td>
                            <td class="text-center">Valor</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('products.show', $product->id) }}">
                            <td>
                                <code>#{{ $product->id }}</code>
                            </td>
                            <td>
                                {{ $product->description }}
                            </td>
                            <td>
                                {{ $product->status_name }}
                            </td>
                            <td class="text-center">
                                R$ {{ number_format($product->price / 100, 2, ',') }}
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
