<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingsAmend extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'bookings_amend';
    protected $guarded = ['amend_id'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'booking_id');
    }
}
