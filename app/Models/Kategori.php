<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Hasmany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kategori extends Model
{
    use HasFactory;
    protected $table = 'kategoris';
    protected $fillable = ['nama'];

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class); 
    }
}
