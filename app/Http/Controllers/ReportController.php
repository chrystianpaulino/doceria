<?php

namespace App\Http\Controllers;

use App\Services\CostService;
use App\Services\CustomerService;
use App\Services\OrderService;
use App\Services\ProviderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $customerService;
    protected $orderService;
    protected $providerService;
    protected $costService;

    public function __construct(CustomerService $customerService, OrderService $orderService, ProviderService $providerService, CostService $costService)
    {
        $this->customerService = $customerService;
        $this->orderService    = $orderService;
        $this->providerService = $providerService;
        $this->costService     = $costService;
    }

    public function index()
    {
        return view('reports.index');
    }

    public function orders(Request $request)
    {
        if ($request->isMethod('POST')) {

            $customerId = $request->customer_id;
            $dateFrom   = $request->from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->from . ' 00:00:00')->format('Y-m-d H:i:s') : null;
            $dateTo     = $request->to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->to . ' 23:59:59')->format('Y-m-d H:i:s') : null;

            $orders = $this->orderService->query()
                ->when(isset($customerId), function ($query) use ($customerId) {
                    return $query->where('customer_id', '=', $customerId);
                })
                ->when(isset($dateFrom), function ($query) use ($dateFrom) {
                    return $query->where('created_at', '>=', $dateFrom);
                })
                ->when(isset($dateTo), function ($query) use ($dateTo) {
                    return $query->where('created_at', '<=', $dateTo);
                })
                ->orderBy('created_at', 'asc')
                ->get();

            return view('reports.orders.report', compact('orders', 'dateTo', 'dateFrom', 'customerId'));
        }

        $customers = $this->customerService->query()->pluck('name', 'id');
        return view('reports.orders.orders', compact('customers'));
    }

    public function costs(Request $request)
    {
        if ($request->isMethod('POST')) {

            $providerId = $request->provider_id;
            $dateFrom   = $request->from ? Carbon::createFromFormat('Y-m-d H:i:s', $request->from . ' 00:00:00')->format('Y-m-d H:i:s') : null;
            $dateTo     = $request->to ? Carbon::createFromFormat('Y-m-d H:i:s', $request->to . ' 23:59:59')->format('Y-m-d H:i:s') : null;

            $costs = $this->costService->query()
                ->when(isset($providerId), function ($query) use ($providerId) {
                    return $query->where('provider_id', '=', $providerId);
                })
                ->when(isset($dateFrom), function ($query) use ($dateFrom) {
                    return $query->where('date_cost', '>=', $dateFrom);
                })
                ->when(isset($dateTo), function ($query) use ($dateTo) {
                    return $query->where('date_cost', '<=', $dateTo);
                })
                ->orderBy('created_at', 'asc')
                ->get();

            return view('reports.costs.report', compact('costs', 'dateTo', 'dateFrom', 'providerId'));
        }

        $providers = $this->providerService->query()->pluck('name', 'id');
        return view('reports.costs.costs', compact('providers'));
    }

}
