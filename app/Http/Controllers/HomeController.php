<?php

namespace App\Http\Controllers;

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

        $ordersToday   = Order::where('delivery_date', 'like', today()->format('Y-m-d') . '%')->get();
        $novosClientes = Customer::where('created_at', 'like', today()->format('Y-m') . '%')->count();

        $mesAtual            = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $primeiroDiaMesAtual = $mesAtual->firstOfMonth()->format('Y-m-d');
        $ontem               = Carbon::yesterday()->format('Y-m-d');
        $qtdDias             = Carbon::createFromFormat('Y-m-d', $ontem)->format('d');

        $arrayPedidos = [];

        $pedidosTotalMes = 0;
        $totalFaturado   = 0;
        for ($i = 0; $i <= $qtdDias; $i++) {
            $diaMesAtual   = Carbon::createFromFormat('Y-m-d', $primeiroDiaMesAtual)->addDays($i);
            $qtdPedidosDia = Order::where('delivery_date', 'like', $diaMesAtual->format('Y-m-d') . '%')->get();

            $dadosDoDiaX     = [
                'diaMes'  => $diaMesAtual->format('d/m'),
                'pedidos' => $qtdPedidosDia->count(),
            ];
            $pedidosTotalMes += $qtdPedidosDia->count();
            $faturadoDia     = $qtdPedidosDia->sum('total_amount');
            $totalFaturado   += $faturadoDia;
            array_push($arrayPedidos, $dadosDoDiaX);
        }

        return view('home', compact('ordersToday', 'arrayPedidos', 'pedidosTotalMes', 'totalFaturado', 'novosClientes'));
    }
}
