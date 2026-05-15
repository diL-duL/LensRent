<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

class Camera extends Model
{
    protected $fillable = ['category_id', 'name', 'brand', 'price_per_day', 'status', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
