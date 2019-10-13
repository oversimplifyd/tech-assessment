<?php

use PHPUnit\Framework\TestCase;

class SpecialOfferControllerTest extends TestCase
{

    private $validatorService;
    private $offerRepo;

    private $controller;
    private $request;

    public function setup()
    {
        $this->offerRepo = $this->createMock(\Vanhack\Voucher\Repositories\SpecialOfferRepository::class);
        $this->validatorService = $this->createMock(\Vanhack\Voucher\Service\ValidatorService::class);

        $this->request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        $this->controller = new \Vanhack\Voucher\Controller\OfferController(
            $this->offerRepo,
            $this->validatorService
        );
    }

    public function testCreateActionFailed()
    {
        $this->validatorService->expects($this->once())
            ->method('createOffer')
            ->will($this->returnValue(['invalid']));
        $this->expectExceptionCode(422);
        $this->controller->createAction($this->request);
    }

    public function testCreateRecipientsActionFailedWithValidation()
    {
        $this->validatorService->expects($this->once())
            ->method('createRecipientOffer')
            ->will($this->returnValue(['invalid']));
        $this->expectExceptionCode(422);
        $this->controller->createRecipientsAction($this->request, 4);
    }

    public function testCreateRecipientsActionFailedWithInvalidOffer()
    {
        $this->validatorService->expects($this->once())
            ->method('createRecipientOffer')
            ->will($this->returnValue([]));

        $this->offerRepo->expects($this->once())
            ->method('find')
            ->will($this->returnValue(FALSE));

        $this->expectExceptionCode(422);
        $this->controller->createRecipientsAction($this->request, 4);
    }
}
