<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

class Category extends Model
{
    protected $fillable = ['name', 'description'];

    public function cameras()
    {
        return $this->hasMany(Camera::class);
    }
}
