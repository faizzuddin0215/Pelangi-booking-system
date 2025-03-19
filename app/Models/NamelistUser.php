<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NamelistUser extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql3';
    protected $table = 'user';
}
