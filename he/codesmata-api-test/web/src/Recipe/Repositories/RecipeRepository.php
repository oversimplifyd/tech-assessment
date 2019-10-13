<?php

namespace HelloFresh\Recipe\Repositories;

use HelloFresh\Recipe\Model\Recipe;
use HelloFresh\Recipe\Repositories\Eloquent\Repository;

class RecipeRepository extends Repository
{

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @return Recipe
     */
    public function model()
    {
        return new Recipe();
    }
}
