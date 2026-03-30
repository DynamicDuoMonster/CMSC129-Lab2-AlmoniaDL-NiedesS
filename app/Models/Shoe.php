<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shoe extends Model
{
    protected $fillable = [
    'shoe_name', 
    'brand', 
    'color', 
    'price', 
    'image_url',
    'category',    // Keep this for now to avoid breaking existing code
    'category_id', // Add this for the new relationship
    'gender', 
    'is_deleted', 
    'deleted_at',
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
