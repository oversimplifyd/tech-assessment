<?php

namespace Vanhack\Voucher\Repositories;

use Vanhack\Voucher\Model\Recipient;
use Vanhack\Voucher\Repositories\Eloquent\Repository;

class RecipientRepository extends Repository
{

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function model()
    {
        return new Recipient();
    }
}
