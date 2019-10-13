<?php

namespace Vanhack\Voucher\Controller;

use Symfony\Component\HttpFoundation\Request;
use Vanhack\Voucher\Controller\HttpExceptions\Http422Exception;
use Vanhack\Voucher\Repositories\SpecialOfferRepository;
use Vanhack\Voucher\Service\ValidatorService;

/**
 * @author Arotimi Busayo <arotimi.busayo@gmail.com>
 *
 * Class VoucherController
 * @package Vanhack\Controller
 */
class OfferController extends BaseController
{
    private $offerRepo;
    private $validator;

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     */
    public function __construct(
        SpecialOfferRepository $offerREpo = null,
        ValidatorService $validator = null
    ) {

        $this->offerRepo = $offerREpo;
        if (is_null($offerREpo)) {
            $this->offerRepo = new SpecialOfferRepository();
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
        $validator = $this->validator->createOffer($request->request->all());
        if (!$validator) {
            return $this->success($this->offerRepo->create($request->request->all())->toArray());
        }
        throw new Http422Exception($validator);
    }

    public function createRecipientsAction(Request $request, int $offerId)
    {
        $validator = $this->validator->createRecipientOffer($request->request->all());
        if (!$validator) {
            $offer = $this->offerRepo->find($offerId);
            if ($offer) {
                if (!$offer->recipients->contains($request->request->get('recipient_id'))) {
                    $offer->recipients()->attach($request->request->all());
                    return $this->success(['Success']);
                }
                throw new Http422Exception('Recipient with this id already Exists for this offer');
            }
            throw new Http422Exception('Invalid Offer');
        }
        throw new Http422Exception($validator);
    }
}
