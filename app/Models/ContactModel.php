<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactModel extends Model
{
    use HasFactory;

    protected $table = 'contact';
    
    protected $fillable = [
        'name',
        'address',
        'telephon',
        'email',
        'facebook',
        'instagram',
        'twitter',
        'location',
        'aplication_version',
        'copyright',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}