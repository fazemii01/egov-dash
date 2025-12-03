<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementsModel extends Model
{
    protected $table = 'announcements';

    protected $fillable =['title','file_path','updated_at','published_at','created_at'];

    protected $casts = [
    'published_at' => 'date',
    'created_at' => 'datetime',
    'updated_at' => 'datetime',
];
}
