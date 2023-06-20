<?php

namespace App\Controller;

use App\Message\PurchaseConfirmationNotification;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class StockTransactionController extends AbstractController
{
    #[Route('/buy', name: 'buy_stock')]
    public function buy(MessageBusInterface $bus): Response
    {
        //$purchaseConfirmationNotification->getOrder()->getBuyer()->getEmail()
        //1-dispatch confirmation message
        $order = new class {

            public  function  getBuyer() :object
            {
            return new class {
                public  function  getEmail() :string
                {
                    return 'exemple@gmail.com';

                }
            };

        }
        public function getId():int
        {
            return 1;
        }
        };
        $bus->dispatch(new PurchaseConfirmationNotification($order->getId()));
        //2-display confirmation to the user

        return   $this->render('exemple.html.twig');
    }
}
