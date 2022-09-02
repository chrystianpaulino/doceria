@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Clientes</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Clientes</span>
                <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Novo Cliente</a>
            </div>
            <div class="table-responsive table-hover">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>ID</td>
                            <td>Nome</td>
                            <td>Contato</td>
                            <td class="text-center">Endereco</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($customers as $customer)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('customers.show', $customer->id) }}">
                            <td>
                                <code>#{{ $customer->id }}</code>
                            </td>
                            <td class="">
                                {{ $customer->name }}
                            </td>
                            <td class="">
                                {{ $customer->phone }}
                            </td>
                            <td class="text-center">
                                {{ $customer->street ? $customer->street . ", " : '' }}{{ $customer->street_number }}
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
