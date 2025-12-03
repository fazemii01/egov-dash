<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VideoModel extends Model
{
    use HasFactory;

    protected $table = 'vidio';
    
    protected $fillable = [
        'title',
        'file', // Sekarang untuk menyimpan YouTube link
        'id_user',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi ke model User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    /**
     * Get YouTube embed URL
     */
    public function getYoutubeEmbedUrl()
    {
        if (!$this->file) return null;
        
        // Extract YouTube ID dari berbagai format URL
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->file, $matches);
        
        if (isset($matches[1])) {
            return 'https://www.youtube.com/embed/' . $matches[1];
        }
        
        return $this->file;
    }

    /**
     * Get YouTube thumbnail
     */
    public function getYoutubeThumbnail()
    {
        if (!$this->file) return null;
        
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->file, $matches);
        
        if (isset($matches[1])) {
            return 'https://img.youtube.com/vi/' . $matches[1] . '/hqdefault.jpg';
        }
        
        return null;
    }
}