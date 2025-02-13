<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = [
        "name",
        "desc",
        "price",
        "stock",
        "category_id",
    ];
    protected $appends = ['category_title'];
    public function getCategoryTitleAttribute()
    {
        return $this->category ? $this->category->title : 'Unknown';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
