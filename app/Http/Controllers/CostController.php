<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Services\CostService;
use Illuminate\Http\Request;

class CostController extends Controller
{
    protected $service;

    public function __construct(CostService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $costs = $this->service->all();
        return view('costs.index', compact('costs'));
    }

    public function create()
    {
        $providers = Provider::all();
        return view('costs.create', compact('providers'));
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
