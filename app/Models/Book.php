<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'title',
        'author',
        'isbn',
        'price',
        'image_url',
        'publisher',
        'category',
        'published_year',
        'copies_total',
        'copies_available',
        'description',
        'is_active',
    ];

    protected $casts = [
        'published_year' => 'integer',
        'price' => 'decimal:2',
        'copies_total' => 'integer',
        'copies_available' => 'integer',
        'is_active' => 'boolean',
    ];

    public function bookIssues(): HasMany
    {
        return $this->hasMany(BookIssue::class);
    }

    public function getIsAvailableAttribute(): bool
    {
        return $this->copies_available > 0;
    }
}
