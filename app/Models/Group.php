<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Group extends Model
{
    use HasFactory;

    protected $table = 'groups'; // Sesuai dengan tabel di database
    protected $fillable = ['kategori_id', 'title', 'deskripsi']; // Hapus 'nama' karena tidak ada di tabel

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
}
