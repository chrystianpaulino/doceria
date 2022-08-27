<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $service;

    public function __construct(CustomerService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $customers = $this->service->all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $customer = $this->service->store($request->all());
        return redirect()->route('customers.index');
    }

    public function show($id)
    {
        $customer = $this->service->find($id);
        return view('customers.show', compact('customer'));
    }

    public function edit($id)
    {
        $customer = $this->service->find($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = $this->service->update($id, $request->all());
        return redirect()->route('customers.index');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back();
    }
}
