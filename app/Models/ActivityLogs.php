<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    use HasFactory;

    public $timestamps = false; // Nonaktifkan timestamps jika tidak diperlukan

    protected $fillable = ['user_id', 'timestamp', 'activity', 'created_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('activity', 'like', '%' . $search . '%')
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', '%' . $search . '%');
                  });
            });
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->where('activity', 'like', "%{$category}%");
        });

        $query->when($filters['startDate'] ?? false, function ($query, $startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        });

        $query->when($filters['endDate'] ?? false, function ($query, $endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        });

        return $query;
    }
}
