<?php

namespace AppBundle\Cabinet\PasswordChange;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class Model
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="Minimal length is 6 characters.")
     * @SecurityAssert\UserPassword(message="Password does not match on what you have now.")
     */
    private $oldPassword;

    /**
     * @var string
     * @Assert\NotBlank()
     * @Assert\Length(min=6, minMessage="Minimal length is 6 characters.")
     */
    private $newPassword;

    /**
     * @return string
     */
    public function getOldPassword()
    {
        return $this->oldPassword;
    }

    /**
     * @param string $oldPassword
     * @return $this
     */
    public function setOldPassword($oldPassword)
    {
        $this->oldPassword = $oldPassword;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }

    /**
     * @param string $newPassword
     * @return $this
     */
    public function setNewPassword($newPassword)
    {
        $this->newPassword = $newPassword;
        return $this;
    }
}
