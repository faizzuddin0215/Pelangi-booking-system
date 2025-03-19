<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionalArrangement extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'optional_arrangement';
    protected $guarded = ['id'];

}
