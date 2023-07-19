<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;
use App\Services\InvoiceService;
use App\Services\SalesTaxService;
use App\Services\PaymentGatewayService;
use App\Services\EmailService;
class InvoiceServiceTest extends TestCase
{   
    /** @test  */
    public function it_proccesses_invoice()
    {   

        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(PaymentGatewayService::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(true);


        $invoiceService = new InvoiceService($salesTaxServiceMock,$gatewayServiceMock,$emailServiceMock);
        $customer = ['name'=>'Gio'];
        $amount = 125;
        $result = $invoiceService->process($customer,$amount);

        $this->assertTrue($result);
    }

    /** @test  */
    public function test_it_sends_receipt_email_when_invoice_is_processed()
    {
        $salesTaxServiceMock = $this->createMock(SalesTaxService::class);
        $gatewayServiceMock = $this->createMock(PaymentGatewayService::class);
        $emailServiceMock = $this->createMock(EmailService::class);

        $gatewayServiceMock->method('charge')->willReturn(true);
        $emailServiceMock->expects($this->once())->method('send')->with(['name'=>'Gio'],'receipt');

        $invoiceService = new InvoiceService($salesTaxServiceMock,$gatewayServiceMock,$emailServiceMock);
        $customer = ['name'=>'Gio'];
        $amount = 125;
        $result = $invoiceService->process($customer,$amount);

        $this->assertTrue($result);
    }

}