<?php

namespace App\Controller;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Message\MailNotification;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(Request $request, EntityManagerInterface $em, MailerInterface $mailer,MessageBusInterface $bus): Response
    {

        $task = new Incident();
        $task->setUser($this->getUser())
            ->setCreatedAt(new \DateTimeImmutable('now'));

        $form = $this->createForm(IncidentType::class, $task);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $em->persist($task);
            $em->flush();


       /*
       $email = (new Email())
                ->from($task->getUser()->getEmail())
                ->to('azize@example.com')
                ->subject('New Incident #' . $task->getId() . ' - ' . $task->getUser()->getEmail())
                ->html('<p>' . $task->getDescription() . '</p>');
        $mailer->send($email);
       */

            $bus->dispatch(new MailNotification($task->getDescription(),$task->getId(),$task->getUser()->getEmail()));

            return $this->redirectToRoute('app_home');
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'HomeController',
        ]);
    }
}
