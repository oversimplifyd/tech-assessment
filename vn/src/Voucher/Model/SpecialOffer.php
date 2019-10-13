<?php

namespace Vanhack\Voucher\Model;

use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    protected $table = 'special_offers';

    protected $fillable = ['name', 'discount_percentage'];

    public function recipients()
    {
        return $this->belongsToMany(Recipient::class, 'offer_recipients', 'offer_id', 'recipient_id');
    }
}
