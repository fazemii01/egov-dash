<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GalleryModel extends Model
{
    use HasFactory;

    protected $table = 'gallery';

    protected $fillable = [
        'activity',
        'time',
        'place'
    ];

    // Relasi one-to-many: satu gallery punya banyak foto
    public function detailsGallery()
    {
        return $this->hasMany(DetailGalleryModel::class, 'gallery_id');
    }

    // Alias untuk photos (supaya lebih intuitif)
    public function photos()
    {
        return $this->hasMany(DetailGalleryModel::class, 'gallery_id');
    }

    /**
     * Mendapatkan jumlah foto di gallery ini
     * Alternatif method jika tidak menggunakan withCount
     */
    public function getPhotosCountAttribute()
    {
        return $this->detailsGallery()->count();
    }
}
