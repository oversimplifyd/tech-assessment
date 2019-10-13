<?php

namespace HelloFresh\Recipe\Model;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name', 'difficulty', 'prep_time', 'vegetarian'];

    public function rating()
    {
        return $this->hasMany(Rating::class);
    }
}
