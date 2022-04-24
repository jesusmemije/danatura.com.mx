<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo', 'codigo', 'tipo', 'cantidad', 'status'
    ];

    protected $appends = ['creation'];

    public function getCreationAttribute()
    {
        return Carbon::parse($this->created_at)->format('d/M/Y');
    }
}
