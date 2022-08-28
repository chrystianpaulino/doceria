@extends('layouts.app')

@section('breads')
    <div class="container">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href=" {{ route('home') }}">Início</a></li>
                <li class="breadcrumb-item active" aria-current="page">Adicionais</li>
            </ol>
        </nav>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Adicionais</strong>
                <a href="{{ route('aditionals.create') }}" class="btn btn-sm btn-primary"><i class="fas fa-plus-circle"></i> Adicionar</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($aditionals as $aditional)
                        <tr class="align-middle" onclick="alertMe(this)" data-url="{{ route('aditionals.show', $aditional->id) }}">
                            <td>
                                <code>#{{ $aditional->id }}</code>
                            </td>
                            <td>
                                {{ $aditional->description }}
                            </td>
                            <td>
                                {{ $aditional->status_name }}
                            </td>
                            <td class="text-center">
                                R$ {{ number_format($aditional->price / 100, 2, ',') }}
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
