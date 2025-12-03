<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BannerModel extends Model
{
    use HasFactory;

    protected $table = 'banner';
    
    protected $fillable = [ 
        'title',
        'file',
        'active',
        'order',
        'link',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'active' => 'string', // 'y' atau 't'
        'order' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}