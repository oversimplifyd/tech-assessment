<?php

namespace Vanhack\Voucher\Model;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = ['code', 'offer_id', 'recipient_id', 'is_used', 'date_used', 'expire_date'];

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function specialOffer()
    {
        return $this->belongsTo(SpecialOffer::class);
    }
}
