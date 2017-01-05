<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class PostController extends Controller
{
    /**
     * @Route("/posts", name="recent_posts")
     */
    public function indexAction(Request $request)
    {
        return $this->render('post/index.html.twig');
    }

    /**
     * @Route("/posts/new", name="all_posts")
     */
    public function newPostsAction(Request $request)
    {
        return $this->render('post/new_posts.html.twig');
    }

    /**
     * @Route("/post/create", name="create_post")
     */
    public function createPostAction(Request $request)
    {
        return $this->render('post/create_post.html.twig');
    }

    /**
     * @Route("/posts/my", name="my_posts")
     */
    public function myPostsAction(Request $request)
    {
        return $this->render('post/my_posts.html.twig');
    }
}
