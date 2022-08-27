<?php

namespace App\Models;

use App\Enums\AditionalEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function App\Helpers\showCentsValue;

class Aditional extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'description',
        'long_description',
        'picture',
        'price',
        'status'
    ];

    /**
     * Scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAtivo($query)
    {
        return $query->where('status', '=', AditionalEnum::ATIVO);
    }

    public $appends = [
        'status_name', 'price_formated'
    ];

    public function getStatusNameAttribute()
    {
        if (!isset($this->attributes['status'])) {
            return null;
        }

        switch ($this->attributes['status']) {
            case AditionalEnum::INATIVO:
                return 'Inativo';
            case AditionalEnum::ATIVO:
                return 'Ativo';
        }
    }

    public function getPriceFormatedAttribute()
    {
        return showCentsValue($this->price);
    }
}
