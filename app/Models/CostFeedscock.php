<?php

namespace App\Models;

use App\Scopes\Franchise\FranchiseScope;
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

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope(new FranchiseScope());
        static::creating(function ($model) {
            $model->franchise_id = session('franchise_id');
        });
    }

    public function feedstock()
    {
        return $this->hasOne(Feedstock::class, 'id', 'feedstock_id');
    }

}
