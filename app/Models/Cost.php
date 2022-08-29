<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cost extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'phone',
        'price',
        'date_cost',
        'payment_type'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value, 'UTF-8');
    }

    public function provider()
    {
        return $this->hasOne(Provider::class, 'id', 'provider_id');
    }

    public function feedstocks()
    {
        return $this->hasMany(CostFeedscock::class);
    }

}
