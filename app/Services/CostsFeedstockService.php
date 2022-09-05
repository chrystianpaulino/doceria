<?php

namespace App\Services;

use App\Models\CostFeedscock;
use Exception;
use function App\Helpers\stringFloatToCents;

class CostsFeedstockService
{
    protected $model;

    public function __construct(CostFeedscock $model)
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
            return $this->model->get();
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

}

