<?php

namespace AppBundle\Cabinet\PasswordChange;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class Changer
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;

    /**
     * @var User
     */
    private $user;

    /**
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param User $user
     */
    public function __construct(
        EntityManager $entityManager,
        UserPasswordEncoderInterface $passwordEncoder,
        User $user
    ) {
        $this->entityManager = $entityManager;
        $this->user = $user;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param Model $passwordChange
     * @throws \Exception
     */
    public function changePassword($passwordChange)
    {
        if (!$this->passwordEncoder->isPasswordValid($this->user, $passwordChange->getOldPassword())) {
            throw new \Exception('Invalid old password has been provided in password change model');
        }

        $this->user->setPassword(
            $this->passwordEncoder->encodePassword($this->user, $passwordChange->getNewPassword())
        );

        $this->entityManager->persist($this->user);
        $this->entityManager->flush();
    }
}
