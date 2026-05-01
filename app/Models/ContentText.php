<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentText extends Model
{
    use HasFactory;

    protected $fillable = [
        'alias',
        'content',
        'description',
        'page_id',
    ];

    protected $casts = [
        'page_id' => 'integer',
    ];
}