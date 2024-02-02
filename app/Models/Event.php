<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Organizer;
use App\Models\Genre;
use App\Models\SubGenre;
use App\Models\Location;
use App\Models\Image;
use App\Models\Offer;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
    public function offers()
    {
        return $this->hasMany(Offer::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function subGenre()
    {
        return $this->belongsTo(SubGenre::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function eventType()
    {
        return $this->belongsTo(EventType::class,'type_id');
    }
}