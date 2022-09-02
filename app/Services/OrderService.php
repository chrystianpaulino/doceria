<?php

namespace App\Services;

use App\Models\Aditional;
use App\Models\Order;
use App\Models\OrderAditional;
use App\Models\OrderProduct;
use App\Models\Product;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function App\Helpers\stringFloatToCents;

class OrderService
{
    protected $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function query()
    {
        try {
            return $this->model->newQuery();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function all()
    {
        try {
            return $this->model->orderBy('id', 'desc')->get();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function find($id)
    {
        try {
            return $this->model->findOrFail($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function store($data)
    {

        try {


            DB::beginTransaction();

            $order                  = new Order();
            $order->customer_id     = $data['customer']['id'];
            $order->price           = $data['price'];
            $order->delivery_fee    = $data['deliveryFee'] ? stringFloatToCents($data['deliveryFee']) : 0;
            $order->discount        = $data['discount'] ? stringFloatToCents($data['discount']) : 0;
            $order->payment_advance = $data['totalPaid'] ? stringFloatToCents($data['totalPaid']) : 0;
            $order->total_amount    = $data['total'];
            $order->delivery_date   = $data['date'] ?? now();
            $order->payment_type    = $data['paymentType'] ?? null;
            $order->obs             = $data['obs'] ?? null;
            $order->save();

            if (isset($data['arrayProducts'])) {
                foreach ($data['arrayProducts'] as $product) {
                    $orderProduct             = new OrderProduct();
                    $orderProduct->order_id   = $order->id;
                    $orderProduct->product_id = $product['id'];
                    $orderProduct->quantity   = $product['quantity'];
                    $orderProduct->price      = $product['price'];
                    $orderProduct->discount   = 0;
                    $orderProduct->total      = $product['price'] * $product['quantity'];
                    $orderProduct->save();
                }
            }

            if (isset($data['arrayAditionals'])) {
                foreach ($data['arrayAditionals'] as $aditional) {
                    $ordeAditional               = new OrderAditional();
                    $ordeAditional->order_id     = $order->id;
                    $ordeAditional->aditional_id = $aditional['id'];
                    $ordeAditional->quantity     = $aditional['quantity'];
                    $ordeAditional->price        = $aditional['price'];
                    $ordeAditional->discount     = 0;
                    $ordeAditional->total        = $aditional['price'] * $aditional['quantity'];
                    $ordeAditional->save();
                }
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::info($e);
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $order                  = $this->find($id);
            $order->customer_id     = $data['customer_id'] ?? $order->customer_id;
            $order->price           = $data['price'] ? stringFloatToCents($data['price']) : $order->price;
            $order->delivery_fee    = $data['delivery_fee'] ? stringFloatToCents($data['delivery_fee']) : $order->delivery_fee;
            $order->discount        = $data['discount'] ? stringFloatToCents($data['discount']) : $order->discount;
            $order->payment_advance = $data['payment_advance'] ? stringFloatToCents($data['payment_advance']) : $order->payment_advance;
            $order->total_amount    = $data['total_amount'] ? stringFloatToCents($data['total_amount']) : $order->total_amount;
            $order->delivery_date   = $data['delivery_date'] ?? $order->delivery_date;
            $order->payment_type    = $data['paymentType'] ?? $order->payment_type;
            $order->obs             = $data['obs'] ?? null;
            $order->save();

            return $order;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $product = $this->find($id);
            $product->delete();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

}

