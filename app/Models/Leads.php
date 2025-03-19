<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leads extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'leads';
    protected $guarded = ['id'];
}
