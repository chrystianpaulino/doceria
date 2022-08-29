<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CostFeedscock extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'cost_id',
        'feedstock_id',
        'quantity',
        'price',
        'discount',
        'total'
    ];

    protected $table = 'cost_feedstocks';


    public function feedstock()
    {
        return $this->hasOne(Feedstock::class, 'id', 'feedstock_id');
    }

}
