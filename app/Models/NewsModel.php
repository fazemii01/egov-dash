<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsModel extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'news';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'headline',
        'images',
        'content',
        'published_at',
        'id_user',
        'count_view'
    ];

    protected $casts = [
        'published_at' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relasi ke user (jika ada)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
