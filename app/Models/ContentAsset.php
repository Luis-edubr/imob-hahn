<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'alias',
        'path',
        'type',
        'description',
        'page_id',
    ];

    protected $casts = [
        'page_id' => 'integer',
    ];
}