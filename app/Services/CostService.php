<?php

namespace App\Services;

use App\Models\Cost;
use App\Models\CostFeedscock;
use Exception;
use function App\Helpers\stringFloatToCents;

class CostService
{
    protected $model;

    public function __construct(Cost $model)
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
            return $this->model->orderBy('date_cost', 'desc')->get();
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
            $cost               = new $this->model();
            $cost->provider_id  = isset($data['provider']['id']) ? $data['provider']['id'] : null;
            $cost->amount       = stringFloatToCents($data['amount']);
            $cost->date_cost    = $data['date'] ?? date('Y-m-d');
            $cost->date_due     = $data['date_due'] ?? date('Y-m-d');
            $cost->date_paid    = isset($data['date_paid']) ? $data['date_paid'] : null;
            $cost->payment_type = $data['paymentType'] ?? null;
            $cost->description  = $data['description'] ?? null;
            $cost->save();

            if (isset($data['qtd_recurrences'])) {
                for ($ocorrencia = 1; $ocorrencia <= $data['qtd_recurrences']; $ocorrencia++) {

                }
            }

            // Insumos do Fornecedor
            if (isset($data['feedstocks'])) {
                foreach ($data['feedstocks'] as $insumo) {
                    if ($insumo['quantity'] > 0) {
                        $costFeedstock               = new CostFeedscock();
                        $costFeedstock->cost_id      = $cost->id;
                        $costFeedstock->feedstock_id = $insumo['id'];
                        $costFeedstock->quantity     = $insumo['quantity'];
                        $costFeedstock->price        = 0;
                        $costFeedstock->discount     = 0;
                        $costFeedstock->total        = 0;
                        $costFeedstock->save();
                    }
                }
            }

            return $cost;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $cost = $this->find($id);
            $cost->delete();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function paid($data, $id)
    {
        $cost               = $this->find($id);
        $cost->payment_type = $data['payment_type'];
        $cost->date_paid    = $data['date_paid'];
        $cost->save();
        return $cost;
    }

}

