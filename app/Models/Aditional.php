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

    public $appends = [
        'status_name', 'price_formated'
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

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setLongDescriptionAttribute($value)
    {
        $this->attributes['long_description'] = mb_strtoupper($value, 'UTF-8');
    }

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
        return showCentsValue($this->attributes['price']);
    }
}
