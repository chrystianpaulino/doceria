<?php

namespace App\Services;

use App\Models\Product;
use Exception;
use function App\Helpers\stringFloatToCents;

class ProductService
{
    protected $model;

    public function __construct(Product $model)
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
            return $this->model->all();
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
            $product                   = new $this->model();
            $product->description      = $data['description'];
            $product->long_description = $data['long_description'] ?? null;
            $product->price            = stringFloatToCents($data['price']);
            $product->status           = $data['status'] ?? '00';
            $product->save();

            return $product;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $product                   = $this->find($id);
            $product->description      = $data['description'] ?? $product->description;
            $product->long_description = $data['long_description'] ?? $product->long_description;
            $product->price            = $data['price'] ? stringFloatToCents($data['price']) : $product->price;
            $product->status           = $data['status'] ?? $product->status;
            $product->save();

            return $product;
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

