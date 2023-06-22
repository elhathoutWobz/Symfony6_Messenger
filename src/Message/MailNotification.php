<?php

namespace App\Message;

use Symfony\Component\Messenger\MessageBusInterface;

class MailNotification
{
    //les infor nessecaire pour envoyer mail
    private $description;
    private $id;
    private $from;

    public function __construct(string $description, int $id, string $from)
    {
        $this->description = $description;
        $this->id = $id;
        $this->from = $from;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

}