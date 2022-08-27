<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderAditional extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'order_id',
        'aditional_id',
        'quantity',
        'price',
        'discount',
        'total'
    ];

    protected $table = 'order_aditionals';

    public function aditional()
    {
        return $this->hasOne(Aditional::class, 'id', 'aditional_id');
    }

}
