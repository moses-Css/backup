<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['photo_id', 'path', 'latitude', 'longtitude', 'waktu'] ;

    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class, 'photo_id');
    }
}
