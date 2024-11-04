<?php

namespace App\Contracts;

interface PaymentGatewayInterface
{
    public function initializePayment(array $data);
    public function verifyPayment(string $reference);
}
