<?php

namespace AppBundle\Cabinet;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class PasswordChanger
{
    /**
     * @var UserInterface
     */
    private $user;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @param UserInterface $user
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct($user, $passwordEncoder)
    {
        $this->user = $user;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param PasswordChange $passwordChange
     */
    public function changePassword($passwordChange)
    {
        if ($this->passwordEncoder->isPasswordValid($this->user, $passwordChange->getOldPassword())) {

        }

        $password = $this->get('security.password_encoder')
            ->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
    }
}
