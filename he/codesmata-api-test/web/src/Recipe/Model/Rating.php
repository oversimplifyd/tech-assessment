<?php

namespace HelloFresh\Recipe\Model;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'recipe_ratings';

    protected $fillable = ['rating', 'recipe_id'];
}
