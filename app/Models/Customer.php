<?php

namespace App\Models;

use App\Enums\CustomerEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'birthdate',
        'street',
        'street_number',
        'neighborhood',
        'city',
        'state',
        'zipcode',
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
            case CustomerEnum::INATIVO:
                return 'Inativo';
            case CustomerEnum::ATIVO:
                return 'Ativo';
        }
    }
}
