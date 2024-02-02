<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}