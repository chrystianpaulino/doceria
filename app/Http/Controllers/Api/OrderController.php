<?php

namespace App\Http\Controllers\Api;

use App\Models\Aditional;
use App\Models\Customer;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function products()
    {
        $products   = Product::ativo()->pluck('description', 'id');
        $aditionals = Aditional::ativo()->pluck('description', 'id');
        $customers = Customer::pluck('name', 'id');
    }
}
