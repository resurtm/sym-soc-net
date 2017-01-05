<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("/users", name="all_users")
     */
    public function indexAction(Request $request)
    {
        return $this->render('user/index.html.twig');
    }

    /**
     * @Route("/users/new", name="new_users")
     */
    public function newUsersAction(Request $request)
    {
        return $this->render('user/new_users.html.twig');
    }
}
