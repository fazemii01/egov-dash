<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DetailGalleryModel extends Model
{
    use HasFactory;

    protected $table = 'details_gallery';

    protected $fillable = [
        'gallery_id',
        'photo',
        'title_photo',
        'caption'
    ];

    // Relasi many-to-one: banyak detail gallery milik satu gallery
    public function gallery()
    {
        return $this->belongsTo(GalleryModel::class, 'gallery_id');
    }
}
