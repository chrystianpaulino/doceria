<?php

namespace App\Http\Controllers;

use App\Models\Cost;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;

class HomeController extends Controller
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


        $arrayPedidos = [];

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
            array_push($arrayPedidos, $dadosDoDiaX);
        }

        return view('home', compact('ordersToday', 'arrayPedidos', 'pedidosTotalMes', 'totalFaturado', 'novosClientes', 'totalGasto', 'ordersTomorrow'));
    }
}
