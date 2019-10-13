<?php

namespace Vanhack\Voucher\Controller\HttpExceptions;

/**
 * Class Http500Exception
 */
class Http422Exception extends AbstractHttpException
{
    protected $httpCode = 422;
    protected $httpMessage = 'Unprocessable Entity';

    public function __construct($appErrorMessage = null)
    {
        parent::__construct($appErrorMessage, $this->httpCode);
    }
}
