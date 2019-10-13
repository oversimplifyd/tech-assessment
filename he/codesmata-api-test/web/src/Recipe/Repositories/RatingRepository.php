<?php

namespace HelloFresh\Recipe\Repositories;

use HelloFresh\Recipe\Model\Rating;
use HelloFresh\Recipe\Repositories\Eloquent\Repository;

class RatingRepository extends Repository
{

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @return Rating
     */
    public function model()
    {
        return new Rating();
    }
}
