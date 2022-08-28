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
            $feedstock        = new $this->model();
            $feedstock->name  = $data['name'];
            $feedstock->price = stringFloatToCents($data['price']);
            $feedstock->save();

            return $feedstock;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $feedstock        = $this->find($id);
            $feedstock->name  = $data['name'] ?? $feedstock->name;
            $feedstock->price = $data['price'] ? stringFloatToCents($data['price']) : $feedstock->price;
            $feedstock->save();

            return $feedstock;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $feedstock = $this->find($id);
            $feedstock->delete();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

}

