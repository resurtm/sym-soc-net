<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BookmarkController extends Controller
{
    /**
     * @Route("/bookmarks", name="bookmarks")
     */
    public function indexAction(Request $request)
    {
        return $this->render('bookmark/index.html.twig');
    }
}
