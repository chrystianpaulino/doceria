<?php

namespace App\Models;

use App\Enums\OrderEnum;
use Cassandra\Custom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'status',
        'customer_id',
        'delivery_fee',
        'discount',
        'total_amount',
        'delivery_date'
    ];

    public $appends = [
        'status_name',
    ];

    public function getStatusNameAttribute()
    {
        if (!isset($this->attributes['status'])) {
            return null;
        }

        switch ($this->attributes['status']) {
            case OrderEnum::PENDENTE:
                return 'Pendente';
            case OrderEnum::PAGA:
                return 'Paga';
            case OrderEnum::ERRO:
                return 'Erro';
        }
    }

    public function aditionals()
    {
        return $this->hasMany(OrderAditional::class);
    }

    public function products()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'customer_id');
    }
}
