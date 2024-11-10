<?php

namespace App\Contracts;

interface PaymentGatewayInterface
{
    public function initializePayment(array $data, array $options);
    public function verifyPayment(string $reference);
}
