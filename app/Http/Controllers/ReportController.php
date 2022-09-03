<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use App\Services\OrderService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected $customerService;
    protected $orderService;

    public function __construct(CustomerService $customerService, OrderService $orderService)
    {
        $this->customerService = $customerService;
        $this->orderService    = $orderService;
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

}
