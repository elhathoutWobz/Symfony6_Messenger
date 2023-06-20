<?php

namespace App\Message;

class PurchaseConfirmationNotification
{
    public function __construct(private  string|int $orderId)
    {

    }

    public function getOrderId():string|int
    {
        return $this->orderId;
    }
}