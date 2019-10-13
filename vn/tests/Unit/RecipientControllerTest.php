<?php

use PHPUnit\Framework\TestCase;

class RecipientControllerTest extends TestCase
{

    private $validatorService;
    private $recipientRepo;

    private $controller;
    private $request;

    public function setup()
    {
        $this->recipientRepo = $this->createMock(\Vanhack\Voucher\Repositories\RecipientRepository::class);
        $this->validatorService = $this->createMock(\Vanhack\Voucher\Service\ValidatorService::class);

        $this->request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

        $this->controller = new \Vanhack\Voucher\Controller\RecipientController(
            $this->recipientRepo,
            $this->validatorService
        );
    }

    public function testCreateActionFailedValidation()
    {
        $this->validatorService->expects($this->once())
            ->method('createRecipients')
            ->will($this->returnValue(['invalid']));
        $this->expectExceptionCode(422);
        $this->controller->createAction($this->request);
    }
}
