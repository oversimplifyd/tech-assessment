<?php

namespace HelloFresh\Exception;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Debug\Exception\FlattenException;

class HelloFreshException
{
    use \HelloFresh\AppTraits\JSONResponse;

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param FlattenException $exception
     * @return JsonResponse
     */
    public function handle(FlattenException $exception)
    {
        if ($exception->getStatusCode() < 500) {
            return $this->error(ApiError::APP_ERR(), $exception->getMessage(), $exception->getStatusCode());
        }
        return $this->error(ApiError::APP_ERR(), "This is us. We are checking..", $exception->getStatusCode());
    }
}
