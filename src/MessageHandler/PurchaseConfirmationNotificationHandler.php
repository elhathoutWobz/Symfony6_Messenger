<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;



#[AsMessageHandler]  // it same to  implements MessageHandlerInterface
class PurchaseConfirmationNotificationHandler
{
    public function __invoke(PurchaseConfirmationNotification $purchaseConfirmationNotification)
    {
        //create pdf
        echo 'create pdf';
        //email the buyer
        echo 'emailing to '.$purchaseConfirmationNotification->getOrder()->getBuyer()->getEmail().'<br>';
    }

}