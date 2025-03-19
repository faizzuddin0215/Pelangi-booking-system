<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dropoff extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'dropoff';
    protected $guarded = ['id'];
}
