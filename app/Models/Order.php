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
        'delivery_date',
        'obs'
    ];

    public $appends = [
        'status_name', 'status_delivery'
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

    public function getStatusDeliveryAttribute()
    {
        $dataEntrega     = $this->attributes['delivery_date'];
        $hoje            = today();
        $diasParaEntrega = $hoje->diffInDays($dataEntrega);

        if ($dataEntrega >= $hoje) {
            if ($diasParaEntrega >= 3) {
                return 'PEDIDO REGISTRADO';
            } else if ($diasParaEntrega == 2) {
                return 'PEDIDO PRÓXIMO';
            } else if ($diasParaEntrega == 1) {
                return 'PEDIDO PARA AMANHÃ';
            } else {
                return 'PEDIDO PARA HOJE';
            }
        } else {
            return 'DATA DE PEDIDO ULTRAPASSADA';
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
