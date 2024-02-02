<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;
use App\Models\LocationType;

class Location extends Model
{
    use HasFactory;

    public function events()
    {
        return $this->hasMany(Event::class, 'location_id');
    }

    public function locationType()
    {
        return $this->belongsTo(LocationType::class, 'location_type_id');
    }
}