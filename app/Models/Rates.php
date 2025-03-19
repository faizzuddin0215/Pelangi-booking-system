<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rates extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'rates';
    protected $guarded = ['price_id'];
}
