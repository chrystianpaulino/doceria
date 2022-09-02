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
        'status_name', 'first_name'
    ];

    public function getFirstNameAttribute()
    {
        $words = explode(" ", $this->attributes['name']);
        return $words[0];
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setStreetAttribute($value)
    {
        $this->attributes['street'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setNeighborhoodAttribute($value)
    {
        $this->attributes['neighborhood'] = mb_strtoupper($value, 'UTF-8');
    }

    public function setCityAttribute($value)
    {
        $this->attributes['city'] = mb_strtoupper($value, 'UTF-8');
    }

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
