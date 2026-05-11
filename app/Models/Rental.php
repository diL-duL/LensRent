<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

class Rental extends Model
{
    protected $fillable = ['user_id', 'camera_id', 'start_date', 'end_date', 'actual_return_date', 'total_price', 'late_fine', 'status'];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'actual_return_date' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function camera()
    {
        return $this->belongsTo(Camera::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
