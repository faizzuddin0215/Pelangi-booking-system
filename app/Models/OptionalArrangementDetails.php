<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OptionalArrangementDetails extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'optional_arrangement_details';
    protected $guarded = ['id'];

}
