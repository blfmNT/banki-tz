<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Image extends Model
{
    use HasFactory;

    const UPDATED_AT = null;
    protected $fillable = ['filename'];

    protected $casts = [
        'created_at' => 'datetime: d-m-Y H:m:s',
    ];

}
