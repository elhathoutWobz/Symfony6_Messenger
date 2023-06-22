<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\WorkflowInterface;

class PostController extends AbstractController
{
    public function __construct(private WorkflowInterface $blogPublishingStateMachine)
    {
        // important de faire le nom de var comme le nom de votre workflow
        //  blog_publishing <=> $blogPublishingStateMachine
    }

    #[Route('/post', name: 'app_post')]
    public function index(): Response
    {
        //create new post
        $post = new Post();

        $post->setTitle('post1');
        $post->setContent('content1');

         $workflow = $this->blogPublishingStateMachine;
         $allTransitionEnable = $workflow->getEnabledTransitions($post);
         $canIDoThisTransition = $workflow->can($post,'publish');
         $applyTransition = $workflow->apply($post,'to_review');

            //dd($post);

        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'post'=>$post
        ]);
    }
}
