<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

class Payment extends Model
{
    protected $fillable = ['rental_id', 'payment_proof', 'status'];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
