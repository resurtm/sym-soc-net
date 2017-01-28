<?php

namespace AppBundle\Controller;

use AppBundle\Cabinet\PasswordChange;
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
        $passwordChange = new PasswordChange\Model();
        $form = $this->createForm(PasswordChange\Type::class, $passwordChange);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordChange = $form->getData();
            $this->get('app.password_change.changer')->changePassword($passwordChange);
            return $this->redirectToRoute('cabinet_password');
        }

        return $this->render('cabinet/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
