<?php

namespace App\Http\Controllers;

use App\Models\Feedstock;
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
        $providers  = Provider::all();
        $feedstocks = Feedstock::all();
        return view('costs.create', compact('providers', 'feedstocks'));
    }

    public function store(Request $request)
    {
        $cost = $this->service->store($request->all());
        return redirect()->route('costs.index');
    }

    public function show($id)
    {
        $cost = $this->service->find($id);
        return view('costs.show', compact('cost'));
    }

    public function edit($id)
    {
        $cost = $this->service->find($id);
        return view('costs.edit', compact('cost'));
    }

    public function update(Request $request, $id)
    {
        $cost = $this->service->update($id, $request->all());
        return redirect()->route('costs.show', $cost->id);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back();
    }
}
