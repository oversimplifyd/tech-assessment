<?php

namespace HelloFresh\Exception;

use MabeEnum\Enum;

class ApiError extends Enum
{
    const APP_ERR = array(1000, 'Sorry, something went wrong..');
    const VALIDATION_ERR = array(2000, 'Validation Error: Invalid Inputs.');
    const AUTH_ERR = array(3000, 'Authentication error.');
    const NO_RESOURCE = array(4000, 'No such resource.');

    /**
     * @return mixed
     */
    public function getErrorDetails($details)
    {
        return [
            "code" => $this->getCode(),
            "description" => $this->getMessage(),
            "details" => $details,
        ];
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->getValue()[0];
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->getValue()[1];
    }
}
