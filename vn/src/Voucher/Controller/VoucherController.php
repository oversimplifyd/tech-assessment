<?php

namespace Vanhack\Voucher\Controller;

use Symfony\Component\HttpFoundation\Request;
use Vanhack\Voucher\Controller\HttpExceptions\Http404Exception;
use Vanhack\Voucher\Repositories\RecipientRepository;
use Vanhack\Voucher\Repositories\SpecialOfferRepository;
use Vanhack\Voucher\Repositories\VoucherRepository;
use Vanhack\Voucher\Service\ValidatorService;

/**
 * @author Arotimi Busayo <arotimi.busayo@gmail.com>
 *
 * Class VoucherController
 * @package Vanhack\Controller
 */
class VoucherController extends BaseController
{
    private $voucherRepo;
    private $offerRepo;
    private $validator;
    private $recipientRepo;

    const INVALID_OFFER = 'No such offer';
    const NO_RECIPIENT = 'No recipients for this offer';
    const INVALID_VOUCHER = 'Voucher is Invalid';
    const EMAIL_RECIPIENT = 'No such recipient for this email';

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     */
    public function __construct(
        VoucherRepository $repository = null,
        SpecialOfferRepository $offerREpo = null,
        RecipientRepository $recipientRepository = null,
        ValidatorService $validator = null
    ) {
        $this->voucherRepo = $repository;
        if (is_null($repository)) {
            $this->voucherRepo = new VoucherRepository();
        }

        $this->offerRepo = $offerREpo;
        if (is_null($offerREpo)) {
            $this->offerRepo = new SpecialOfferRepository();
        }

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
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     */
    public function indexAction()
    {
        return $this->success(['Welcome to Voucher Pool']);
    }

    /**
     * @author Arotimi Busayo <arotimi.busayo@gmail.com>
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function generateAction(int $offer_id, string $expire_date)
    {
        $offer = $this->offerRepo->find($offer_id);
        if ($offer) {
            if ($offer->recipients) {
                foreach ($offer->recipients as $recipient) {
                    $this->voucherRepo->insert([
                        'code' => $this->generateVoucher(8),
                        'offer_id' => $offer_id,
                        'recipient_id' => $recipient->id,
                        'expire_date' => $expire_date,
                    ]);
                }
                return $this->success(['success']);
            }
            throw new Http404Exception(self::NO_RECIPIENT);
        }
        throw new Http404Exception(self::INVALID_OFFER);
    }

    public function getVouchers(string $email)
    {
        $recipient = $this->recipientRepo->findBy('email', $email)->first();

        if ($recipient) {
            $results = $this->voucherRepo->getRecipientSpecialOfferVouchers($recipient->id);
            return $this->success($results);
        }
        throw new Http404Exception(self::EMAIL_RECIPIENT);
    }

    public function verifyVoucher(string $code)
    {
        if ($this->voucherRepo->findBy('code', $code)) {
            return $this->success(['Valid Voucher']);
        }
        throw new Http404Exception(self::INVALID_VOUCHER);
    }

    private function generateVoucher(int $count)
    {
        $code = substr(md5(uniqid(mt_rand(), true)), 0, $count);
        if ( !$this->voucherRepo->findBy('code', $code)) {
            return $code;
        }
        return $this->generateVoucher($count);
    }
}
