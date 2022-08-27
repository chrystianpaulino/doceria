<?php

namespace App\Services;

use App\Models\Aditional;
use App\Models\Product;
use Exception;
use function App\Helpers\stringFloatToCents;

class AditionalService
{
    protected $model;

    public function __construct(Aditional $model)
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
            $aditional                   = new $this->model();
            $aditional->description      = $data['description'];
            $aditional->long_description = $data['long_description'] ?? null;
            $aditional->price            = stringFloatToCents($data['price']);
            $aditional->status           = $data['status'] ?? '00';
            $aditional->save();

            return $aditional;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $aditional                   = $this->find($id);
            $aditional->description      = $data['description'] ?? $aditional->description;
            $aditional->long_description = $data['long_description'] ?? $aditional->long_description;
            $aditional->price            = $data['price'] ? stringFloatToCents($data['price']) : $aditional->price;
            $aditional->status           = $data['status'] ?? $aditional->status;
            $aditional->save();

            return $aditional;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $aditional = $this->find($id);
            $aditional->delete();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

}

