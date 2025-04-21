<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class namelist extends Model
{
    public $timestamps = false;
    protected $connection = 'mysql3';
    protected $table = 'name_list';
}
