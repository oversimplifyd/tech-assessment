<?php

namespace Vanhack\Voucher\Service;

use Respect\Validation\Validator as v;

/**
 * @author Arotimi Busayo <arotimi.busayo@gmail.com>
 *
 * Class ValidatorService
 * @package Vanhack\Voucher\Validator
 */
class ValidatorService
{
    private static $messageStack = [];

    /**
     * @param array $input
     * @return array
     */
    public function createVoucher(array $input)
    {
        self::clearMessageStack();

        if (!$this->isEmpty('offer_id', $input)) {
            if (!v::numeric()->validate($input['offer_id'])) {
                self::$messageStack[] = 'offer_id is not valid';
            }
        }

        if (!$this->isEmpty('recipient_id', $input)) {
            if (!v::numeric()->validate($input['recipient_id'])) {
                self::$messageStack[] = 'recipient_id is not valid';
            }
        }

        return self::$messageStack;
    }

    public function createOffer(array $input)
    {
        self::clearMessageStack();

        if (!$this->isEmpty('name', $input)) {
            if (!v::stringType()->validate($input['name'])) {
                self::$messageStack[] = 'name is not valid';
            }
        }

        if (!$this->isEmpty('discount_percentage', $input)) {
            if (!v::floatVal()->validate($input['discount_percentage'])) {
                self::$messageStack[] = 'discount_percentage is not valid';
            }
        }

        return self::$messageStack;
    }

    public function createRecipients(array $input)
    {
        self::clearMessageStack();

        if (!$this->isEmpty('name', $input)) {
            if (!v::stringType()->validate($input['name'])) {
                self::$messageStack[] = 'name is not valid';
            }
        }

        if (!$this->isEmpty('email', $input)) {
            if (!v::email()->validate($input['email'])) {
                self::$messageStack[] = 'email is not valid';
            }
        }

        return self::$messageStack;
    }

    public function createRecipientOffer(array $input)
    {
        self::clearMessageStack();

        if (!$this->isEmpty('recipient_id', $input)) {
            if (!v::numeric()->validate($input['recipient_id'])) {
                self::$messageStack[] = 'recipient_id is not valid';
            }
        }

        return self::$messageStack;
    }

    private function isEmpty(string $input, array $parent)
    {
        if (empty($parent[$input])) {
            self::$messageStack[] = $input. ' is required';
            return true;
        }
        return false;
    }

    protected static function clearMessageStack()
    {
        self::$messageStack = [];
    }
}
