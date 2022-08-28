<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Feedstock;
use App\Models\Product;
use App\Models\Provider;
use Exception;
use function App\Helpers\stringFloatToCents;

class ProviderService
{
    protected $model;

    public function __construct(Provider $model)
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
            $provider        = new $this->model();
            $provider->name  = $data['name'];
            $provider->phone = $data['phone'];
            $provider->save();

            return $provider;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $provider        = $this->find($id);
            $provider->name  = $data['name'] ?? $provider->name;
            $provider->phone = $data['phone'] ?? $provider->phone;
            $provider->save();

            return $provider;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $provider = $this->find($id);
            $provider->delete();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

}

