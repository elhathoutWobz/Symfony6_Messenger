<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\TransitionEvent;

class BlogPublishingSubscriber implements EventSubscriberInterface
{

    public  function handleReview(TransitionEvent $event)
    {
        /**
         * @var Post $post
         */
        $post = $event->getSubject();
        //set dateViewedAt when event executed
        $post->setReviewedAt(new \DateTime() );

        //dd($post);

    }

    public static function getSubscribedEvents(): array
    {
        return [
         'workflow.blog_publishing.transition.to_review'=>'handleReview'
        ];
    }
}
