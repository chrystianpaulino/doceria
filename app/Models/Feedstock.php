<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedstock extends Model
{
    // materia-prima (insumos)

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'price'
    ];


    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value, 'UTF-8');
    }
}
