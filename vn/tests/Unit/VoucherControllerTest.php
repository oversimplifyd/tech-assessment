<?php

use PHPUnit\Framework\TestCase;

class VoucherControllerTest extends TestCase
{

    private $validatorService;
    private $voucherRepo;
    private $recipientRepo;
    private $offerRepo;

    private $controller;
    private $request;

    public function setup()
    {
        $this->recipientRepo = $this->createMock(\Vanhack\Voucher\Repositories\RecipientRepository::class);
        $this->voucherRepo = $this->createMock(\Vanhack\Voucher\Repositories\VoucherRepository::class);
        $this->offerRepo = $this->createMock(\Vanhack\Voucher\Repositories\SpecialOfferRepository::class);
        $this->validatorService = $this->createMock(\Vanhack\Voucher\Service\ValidatorService::class);

        $this->request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        $this->controller = new \Vanhack\Voucher\Controller\VoucherController(
            $this->voucherRepo,
            $this->offerRepo,
            $this->recipientRepo,
            $this->validatorService
        );
    }

    public function testIndexAction()
    {
        $this->assertEquals(
            '{"status":true,"data":["Welcome to Voucher Pool"],"meta":[]}',
            $this->controller->indexAction()->getContent());
    }

    public function testGenerateActionSuccess()
    {
        $offer = new stdClass();
        $recipientObject = new stdClass();
        $recipientObject->id = 1;
        $offer->recipients = [$recipientObject];
        $this->offerRepo->expects($this->once())
            ->method('find')
            ->will($this->returnValue($offer));
        $this->voucherRepo->expects($this->any())
            ->method('insert')
            ->will($this->returnValue(TRUE));
        $this->assertEquals(
            '{"status":true,"data":["success"],"meta":[]}',
            $this->controller->generateAction(1, '2018-09-23')->getContent());
    }

    public function testGenerateActionFailed()
    {
        $this->offerRepo->expects($this->once())
            ->method('find')
            ->will($this->returnValue(FALSE));
        $this->expectExceptionCode(404);
        $this->controller->generateAction(1, '2018-92-93');
    }

    public function testVerifyVoucherSucess()
    {
        $this->voucherRepo->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue(TRUE));
        $this->assertEquals(
            '{"status":true,"data":["Valid Voucher"],"meta":[]}',
            $this->controller->verifyVoucher('3lskd9')->getContent());
    }

    public function testVerifyVoucherFailed()
    {
        $this->voucherRepo->expects($this->any())
            ->method('findBy')
            ->will($this->returnValue(FALSE));
        $this->expectExceptionCode(404);
        $this->controller->verifyVoucher('-93');
    }
}
