<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionalCodeBooking extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'optional_code_booking';
    protected $guarded = ['id'];
}
