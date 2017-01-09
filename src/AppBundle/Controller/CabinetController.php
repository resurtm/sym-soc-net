<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CabinetController extends Controller
{
    /**
     * @Route("/cabinet/settings", name="cabinet_settings")
     */
    public function settingsAction(Request $request)
    {
        return $this->render('cabinet/settings.html.twig');
    }

    /**
     * @Route("/cabinet/password", name="cabinet_password")
     */
    public function passwordAction(Request $request)
    {
        return $this->render('cabinet/password.html.twig');
    }
}
