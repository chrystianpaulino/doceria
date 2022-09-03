<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;

class PerformaceController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $ordersToday    = Order::where('delivery_date', 'like', today()->format('Y-m-d') . '%')->get();
        $ordersTomorrow = Order::where('delivery_date', 'like', today()->addDay()->format('Y-m-d') . '%')->get();
        $novosClientes  = Customer::where('created_at', 'like', today()->format('Y-m') . '%')->count();
        $totalGasto     = Cost::where('created_at', 'like', today()->format('Y-m') . '%')->sum('amount');

        $mesAtual            = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $primeiroDiaMesAtual = $mesAtual->firstOfMonth()->format('Y-m-d');
        $qtdDias             = Carbon::now()->daysInMonth;


        $arrayPedidosMes = [];
        $pedidosTotalMes = 0;
        $totalFaturado   = 0;

        for ($i = 0; $i < $qtdDias; $i++) {
            $diaMesAtual   = Carbon::createFromFormat('Y-m-d', $primeiroDiaMesAtual)->addDays($i);
            $qtdPedidosDia = Order::where('delivery_date', 'like', $diaMesAtual->format('Y-m-d') . '%')->get();

            $dadosDoDiaX = [
                'diaMes'  => $diaMesAtual->format('d'),
                'pedidos' => $qtdPedidosDia->count(),
            ];

            $pedidosTotalMes += $qtdPedidosDia->count();
            $faturadoDia     = $qtdPedidosDia->sum('total_amount');
            $totalFaturado   += $faturadoDia;

            array_push($arrayPedidosMes, $dadosDoDiaX);
        }

        $arrayPedidosAno = [];

        for ($i = 12; $i >= 0; $i--) {
            $mes           = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->firstOfMonth()->subMonths($i);
            $qtdPedidosMes = Order::where('delivery_date', 'like', $mes->format('Y-m') . '%')->count();

            $dadosDoMesX = [
                'diaMes'  => ucwords($mes->format('m/Y')),
                'pedidos' => $qtdPedidosMes,
            ];

            array_push($arrayPedidosAno, $dadosDoMesX);
        }

        return view('performaces.index', compact('ordersToday', 'arrayPedidosAno', 'arrayPedidosMes', 'pedidosTotalMes', 'totalFaturado', 'novosClientes', 'totalGasto', 'ordersTomorrow'));
    }
}
