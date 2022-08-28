<?php

namespace App\Services;

use App\Models\Cost;
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

    public function store($data)
    {
        try {
            $cost              = new $this->model();
            $cost->provider_id = $data['provider']['id'];
            $cost->amount      = stringFloatToCents($data['amount']);
            $cost->save();

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

}

