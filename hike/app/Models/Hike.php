<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Hike extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'distance',
        'duration',
        'elevation_gain',
        'description',
    ];

    /**
     * permet  de créer un slug à partir du name
     */
    public function getSlug()
    {
        return Str::slug($this->name);
    }
}
