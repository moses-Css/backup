<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Photo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'photos';

    protected $fillable = ['group_id'];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(Image::class);
    }

    protected static function booted()
    {
        static::deleting(function ($photo) {
            $photo->images->each->delete();
        });
    }
}
