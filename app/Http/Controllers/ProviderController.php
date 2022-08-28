<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\FeedstockService;
use App\Services\ProductService;
use App\Services\ProviderService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    protected $service;

    public function __construct(ProviderService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $providers = $this->service->all();
        return view('providers.index', compact('providers'));
    }

    public function create()
    {
        return view('providers.create');
    }

    public function store(Request $request)
    {
        $provider = $this->service->store($request->all());
        return redirect()->route('providers.index');
    }

    public function show($id)
    {
        $provider = $this->service->find($id);
        return view('providers.show', compact('provider'));
    }

    public function edit($id)
    {
        $provider = $this->service->find($id);
        return view('providers.edit', compact('provider'));
    }

    public function update(Request $request, $id)
    {
        $provider = $this->service->update($id, $request->all());
        return redirect()->route('providers.show', $provider->id);
    }

    public function destroy($id)
    {
        $this->service->destroy($id);
        return redirect()->back();
    }
}
