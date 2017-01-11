<?php

namespace AppBundle\Controller;

use AppBundle\Cabinet\PasswordChange;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        $passwordChange = new PasswordChange();

        $form = $this->createFormBuilder($passwordChange)
            ->add('oldPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'invalid_message' => 'The old password fields must match.',
                'first_options'  => array('label' => 'Old Password'),
                'second_options' => array('label' => 'Repeat Old Password'),
            ])
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'required' => true,
                'invalid_message' => 'The new password fields must match.',
                'first_options'  => array('label' => 'New Password'),
                'second_options' => array('label' => 'Repeat New Password'),
            ])
            ->add('save', SubmitType::class, ['label' => 'Update'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $passwordChange = $form->getData();
            $this->get('app.password_changer')->changePassword($passwordChange);

            return $this->redirectToRoute('cabinet_password');
        }

        return $this->render('cabinet/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
