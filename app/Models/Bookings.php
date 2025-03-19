<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'bookings';
    protected $guarded = ['booking_id'];
    protected $primaryKey = 'booking_id';

    public function rooms()
    {
        return $this->hasMany(Room::class, 'booking_id');
    }
}
