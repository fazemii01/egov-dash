<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceModels extends Model
{
    // Nama tabel di database
    protected $table = 'service';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = ['title', 'content', 'updated_at', 'created_at','sop','file_download'];
}
