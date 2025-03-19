<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupDetails extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'pickup_details';
    protected $guarded = ['id'];
}
