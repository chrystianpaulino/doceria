<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\AditionalService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class AditionalController extends Controller
{
    protected $service;

    public function __construct(AditionalService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $aditionals = $this->service->all();
        return view('aditionals.index', compact('aditionals'));
    }

    public function create()
    {
        return view('aditionals.create');
    }

    public function store(Request $request)
    {
        $aditional = $this->service->store($request->all());
        return redirect()->route('aditionals.index');
    }

    public function show($id)
    {
        $aditional = $this->service->find($id);
        return view('aditionals.show', compact('aditional'));
    }

    public function edit($id)
    {
        $aditional = $this->service->find($id);
        return view('aditionals.edit', compact('aditional'));
    }

    public function update(Request $request, $id)
    {
        $aditional = $this->service->update($id, $request->all());
        return redirect()->route('aditionals.index');
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back();
    }
}
