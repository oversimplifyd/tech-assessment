<?php

namespace Vanhack\Voucher\Repositories;

use Vanhack\Voucher\Model\Voucher;
use Vanhack\Voucher\Repositories\Eloquent\Repository;

class VoucherRepository extends Repository
{

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function model()
    {
        return new Voucher();
    }

    public function getRecipientSpecialOfferVouchers($recipient_id)
    {
        return (Voucher::join('special_offers', 'special_offers.id', '=', 'vouchers.offer_id')
            ->join('recipients', 'recipients.id', '=', 'vouchers.recipient_id')
            ->where('vouchers.recipient_id', $recipient_id)
            ->select('special_offers.name', 'vouchers.code')
            ->get())->toArray();
    }
}
