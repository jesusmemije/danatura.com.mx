<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    // use HasFactory;
    protected $table = 'compra';

    protected $primaryKey = 'id';

    // insert automatically
    public $timestamps = true;
}
