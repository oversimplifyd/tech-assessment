<?php

namespace Vanhack\Voucher\AppTraits;

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
    public function success(array $data, int $code = 200, array $meta = [])
    {
        return new SymfonyJsonResponse([
            "status" => true,
            "data" => $data,
            "meta" => $meta
        ], $code);
    }
}
