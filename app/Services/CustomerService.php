<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Product;
use Exception;

class CustomerService
{
    protected $model;

    public function __construct(Customer $model)
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
            $customer                = new $this->model();
            $customer->name          = $data['name'];
            $customer->email         = $data['email'];
            $customer->phone         = $data['phone'] ?? null;
            $customer->birthdate     = $data['birthdate'] ?? null;
            $customer->street        = $data['street'] ?? null;
            $customer->street_number = $data['street_number'] ?? null;
            $customer->neighborhood  = $data['neighborhood'] ?? null;
            $customer->city          = $data['city'] ?? null;
            $customer->state         = $data['state'] ?? null;
            $customer->zipcode       = $data['zipcode'] ?? null;
            $customer->save();

            return $customer;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function update($id, $data)
    {
        try {
            $customer                = $this->find($id);
            $customer->name          = $data['name'] ?? $customer->name;
            $customer->email         = $data['email'] ?? $customer->email;
            $customer->phone         = $data['phone'] ?? $customer->phone;
            $customer->birthdate     = $data['birthdate'] ?? $customer->birthdate;
            $customer->street        = $data['street'] ?? $customer->street;
            $customer->street_number = $data['street_number'] ?? $customer->street_number;
            $customer->neighborhood  = $data['neighborhood'] ?? $customer->neighborhood;
            $customer->city          = $data['city'] ?? $customer->city;
            $customer->state         = $data['state'] ?? $customer->state;
            $customer->zipcode       = $data['zipcode'] ?? $customer->zipcode;
            $customer->save();

            return $customer;
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function destroy($id)
    {
        try {
            $customer = $this->find($id);
            $customer->delete();

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

}

