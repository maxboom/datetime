<?php

namespace App\Controller;

use App\Form\DateTimeType;
use App\Repository\PostRepository;
use Domain\Post\PostManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostController extends AbstractController
{
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findBy([], ['id' => 'desc'], 100);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/post/{id}", name="app_post_show")
     */
    public function show(PostManager $postManager, $id): Response
    {
        return $this->render('post/show.html.twig', [
            'post' => $postManager->findPost($id),
        ]);
    }
}