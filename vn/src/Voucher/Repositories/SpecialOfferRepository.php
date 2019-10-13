<?php

namespace Vanhack\Voucher\Repositories;

use Vanhack\Voucher\Model\SpecialOffer;
use Vanhack\Voucher\Repositories\Eloquent\Repository;

class SpecialOfferRepository extends Repository
{

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function model()
    {
        return new SpecialOffer();
    }
}
