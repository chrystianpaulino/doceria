@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Fornecedores</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Fornecedores</span>
                <a href="{{ route('providers.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Fornecedor</a>
            </div>
            <div class="table-responsive table-hover p-2">
                <table class="table table-hover data-table">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td class="text-center">Nome</td>
                            <td class="text-center">Contato</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($providers as $provider)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('providers.show', $provider->id) }}">
                            <td>
                                <code>#{{ $provider->id }}</code>
                            </td>
                            <td class="text-center">
                                {{ $provider->name }}
                            </td>
                            <td class="text-center">
                                {{ $provider->phone }}
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
