<?php

namespace HelloFresh\AppTraits;

use HelloFresh\Exception\ApiError;
use Symfony\Component\HttpFoundation\JsonResponse as SymfonyJsonResponse;

trait JSONResponse
{

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param $data
     * @param int $code
     * @param array $meta
     * @return SymfonyJsonResponse
     */
    public function success($data, $code = 200, $meta = [])
    {
        return new SymfonyJsonResponse([
            "status" => true,
            "data" => $data,
            "meta" => $meta
        ], $code);
    }

    /**
     *  @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param ApiError $error
     * @param $message
     * @param int $code
     * @return SymfonyJsonResponse
     */
    public function error(ApiError $error, $message, $code = 404)
    {
        return new SymfonyJsonResponse([
            "status" => false,
            "errors" =>  $error->getErrorDetails($message)
        ], $code);
    }
}
