<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class SubGenre extends Model
{
    use HasFactory;

    public function events()
    {
        return $this->hasMany(Event::class, 'sub_genre_id');
    }
}