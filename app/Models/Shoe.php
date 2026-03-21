<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    protected $fillable = [
        'shoe_name', 'brand', 'color', 'price', 'image_url',
        'category', 'gender', 'is_deleted', 'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'color'     => 'array',
            'image_url' => 'array',
            'is_deleted' => 'boolean',
            'deleted_at' => 'datetime',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_deleted', false);
    }

    public function scopeTrashed($query)
    {
        return $query->where('is_deleted', true);
    }
}
