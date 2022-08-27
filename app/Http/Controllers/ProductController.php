<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $products = $this->service->all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $product = $this->service->store($request->all());
        return redirect()->route('products.index');
    }

    public function show($id)
    {
        $product = $this->service->find($id);
        return view('products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = $this->service->find($id);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $product = $this->service->update($id, $request->all());
        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back();
    }
}
