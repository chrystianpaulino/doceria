<?php

namespace App\Http\Controllers;

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

        $orders = Order::where('delivery_date', 'like', today()->format('Y-m-d') . '%')
            ->orderBy('created_at', 'asc')
            ->get();

        $mesAtual            = Carbon::createFromFormat('Y-m-d', date('Y-m-d'));
        $primeiroDiaMesAtual = $mesAtual->firstOfMonth()->format('Y-m-d');
        $ontem               = Carbon::yesterday()->format('Y-m-d');
        $qtdDias             = Carbon::createFromFormat('Y-m-d', $ontem)->format('d');

        $array = [];

        for ($i = 0; $i <= $qtdDias; $i++) {
            $diaMesAtual   = Carbon::createFromFormat('Y-m-d', $primeiroDiaMesAtual)->addDays($i);
            $qtdPedidosDia = Order::where('delivery_date', 'like', $diaMesAtual->format('Y-m-d') . '%')->count();

            $dadosDoDiaX = [
                'diaMes'  => $diaMesAtual->format('d/m'),
                'pedidos' => $qtdPedidosDia,
            ];

            array_push($array, $dadosDoDiaX);
        }

        return view('home', compact('orders', 'array'));
    }
}
