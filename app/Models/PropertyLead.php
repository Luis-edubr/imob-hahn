<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'cpf',
        'email',
        'phone',
        'address',
        'zip',
        'neighborhood',
        'number',
        'city',
        'state',
        'complement',
        'property_type',
        'suites',
        'bedrooms',
        'bathrooms',
        'rooms',
        'garages',
        'bbq',
        'additional_info',
        'status',
    ];

    protected $casts = [
        'suites' => 'integer',
        'bedrooms' => 'integer',
        'bathrooms' => 'integer',
        'rooms' => 'integer',
        'garages' => 'integer',
        'bbq' => 'boolean',
    ];
}
