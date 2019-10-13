<?php

namespace Vanhack\Voucher\Controller;

use Symfony\Component\HttpFoundation\Request;
use Vanhack\Voucher\Controller\HttpExceptions\Http422Exception;
use Vanhack\Voucher\Repositories\RecipientRepository;
use Vanhack\Voucher\Service\ValidatorService;

/**
 * @author Arotimi Busayo <arotimi.busayo@gmail.com>
 *
 * Class VoucherController
 * @package Vanhack\Controller
 */
class RecipientController extends BaseController
{
    private $recipientRepo;
    private $validator;

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     */
    public function __construct(
        RecipientRepository $recipientRepository = null,
        ValidatorService $validator = null
    ) {

        $this->recipientRepo = $recipientRepository;
        if (is_null($recipientRepository)) {
            $this->recipientRepo = new RecipientRepository();
        }

        $this->validator = $validator;
        if (is_null($validator)) {
            $this->validator = new ValidatorService();
        }
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function createAction(Request $request)
    {
        $validator = $this->validator->createRecipients($request->request->all());
        if (!$validator) {
            return $this->success($this->recipientRepo->create($request->request->all())->toArray());
        }
        throw new Http422Exception($validator);
    }
}
