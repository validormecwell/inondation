<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TanaInonderModel extends Model
{
    protected $table = 'tana_inonder';

    protected $fillable = ['geom', 'region', 'fokontany', 'cl_danger'];
    use HasFactory;
}
