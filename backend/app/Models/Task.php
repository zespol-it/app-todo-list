<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];

    const STATUS_PENDING = 'pending';
    const STATUS_COMPLETED = 'completed';
} 