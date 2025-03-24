<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receipt extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'receipt';
    protected $guarded = ['AI_ID'];
    protected $primaryKey = 'AI_ID';

}
