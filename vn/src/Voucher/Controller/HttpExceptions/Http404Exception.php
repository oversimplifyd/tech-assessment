<?php

namespace Vanhack\Voucher\Controller\HttpExceptions;

/**
 * Class Http500Exception
 */
class Http404Exception extends AbstractHttpException
{
    protected $httpCode = 404;
    protected $httpMessage = 'Not Found';

    public function __construct($appErrorMessage = null)
    {
        parent::__construct($appErrorMessage, $this->httpCode);
    }
}
