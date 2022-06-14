<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image',
        'status',
        'user_id'
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
