<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\FeedstockService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class FeedstockController extends Controller
{
    protected $service;

    public function __construct(FeedstockService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $feedstocks = $this->service->all();
        return view('feedstocks.index', compact('feedstocks'));
    }

    public function create()
    {
        return view('feedstocks.create');
    }

    public function store(Request $request)
    {
        $feedstock = $this->service->store($request->all());
        return redirect()->route('feedstocks.index');
    }

    public function show($id)
    {
        $feedstock = $this->service->find($id);
        return view('feedstocks.show', compact('feedstock'));
    }

    public function edit($id)
    {
        $feedstock = $this->service->find($id);
        return view('feedstocks.edit', compact('feedstock'));
    }

    public function update(Request $request, $id)
    {
        $feedstock = $this->service->update($id, $request->all());
        return redirect()->route('feedstocks.show', $feedstock->id);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back();
    }
}
