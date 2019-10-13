<?php

namespace Vanhack\Voucher\Controller\HttpExceptions;

/**
 * Class Http500Exception
 */
class Http400Exception extends AbstractHttpException
{
    protected $httpCode = 400;
    protected $httpMessage = 'Bad Request';

    public function __construct($appErrorMessage = null)
    {
        parent::__construct($appErrorMessage, $this->httpCode);
    }
}
