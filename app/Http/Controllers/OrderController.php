<?php

namespace App\Http\Controllers;

use App\Models\Aditional;
use App\Models\Customer;
use App\Models\Product;
use App\Services\AditionalService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $service;
    protected $productService;
    protected $aditionalService;

    public function __construct(OrderService $service, ProductService $productService, AditionalService $aditionalService)
    {
        $this->service          = $service;
        $this->productService   = $productService;
        $this->aditionalService = $aditionalService;
    }

    public function index()
    {
        $orders = $this->service->all();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products   = Product::ativo()->get();
        $aditionals = Aditional::ativo()->get();
        $customers  = Customer::select('id', 'name')->get();

        return view('orders.create', compact('products', 'aditionals', 'customers'));
    }

    public function store(Request $request)
    {
        $order = $this->service->store($request->all());
        return redirect()->route('orders.index');
    }

    public function show($id)
    {
        $order = $this->service->find($id);
        return view('orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = $this->service->find($id);
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $order = $this->service->update($id, $request->all());
        return redirect()->route('orders.show', $order->id);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back();
    }
}
