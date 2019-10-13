<?php

namespace Vanhack\Voucher\Controller\HttpExceptions;


/**
 * Class Http500Exception
 */
class Http500Exception extends AbstractHttpException
{
    protected $httpCode = 500;
    protected $httpMessage = 'Internal Server Error';

    public function __construct($appErrorMessage = null)
    {
        parent::__construct($appErrorMessage, $this->httpCode);
    }
}
