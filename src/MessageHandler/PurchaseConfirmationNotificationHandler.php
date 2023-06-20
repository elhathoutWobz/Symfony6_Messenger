<?php

namespace App\MessageHandler;

use App\Message\PurchaseConfirmationNotification;
use Mpdf\Mpdf;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Mime\Email;


//#[AsMessageHandler]  // it same to  implements MessageHandlerInterface
class PurchaseConfirmationNotificationHandler implements MessageHandlerInterface
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function __invoke(PurchaseConfirmationNotification $purchaseConfirmationNotification)
    {
        //1*******create pdf******
        $mpdf = new Mpdf();
        $content ="<h1>Cont for order{$purchaseConfirmationNotification->getOrderId()}</h1>";
        $content.="<p>1258$</p>";

        $mpdf->writeHtml($content);
        $contractNotPdf = $mpdf->output('','S');

        //2********email the buyer****

        $email = (new Email())

            ->from('abdelaazizeelhathoute.2018@gmail.com')
            ->to('azize@gmail.com')
            ->subject('contact'.$purchaseConfirmationNotification->getOrderId())
            ->text('text text')
            ->attach($contractNotPdf,'contract-note.pdf');
              //send email
              $this->mailer->send($email);
    }

}