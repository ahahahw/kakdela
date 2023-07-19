<?php

namespace App\Services;

interface PaymentGatewayInterface
{
    public function charge(array $customer, float $amount, float $tax): bool;
}