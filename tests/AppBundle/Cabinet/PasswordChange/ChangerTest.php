<?php

namespace Tests\AppBundle\Cabinet\PasswordChange;

use AppBundle\Cabinet\PasswordChange\Changer;
use AppBundle\Cabinet\PasswordChange\Exception\InvalidPasswordException;
use AppBundle\Cabinet\PasswordChange\Model;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ChangerTest extends KernelTestCase
{
    const PASSWORD1 = '123123';
    const PASSWORD2 = '321321';

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setUp()
    {
        self::bootKernel();

        $this->container = self::$kernel->getContainer();
    }

    public function testChangePasswordException()
    {
        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        /** @var UserPasswordEncoderInterface $passwordEncoder */
        $passwordEncoder = $this->container->get('security.password_encoder');

        /** @var User|\PHPUnit_Framework_MockObject_MockObject $passwordEncodeUser */
        $passwordEncodeUser = $this->createMock(User::class);
        $passwordEncodeUser->expects($this->once())
            ->method('getSalt')
            ->willReturn(null);
        $encodedPassword1 = $passwordEncoder->encodePassword($passwordEncodeUser, self::PASSWORD1);

        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('getPassword')
            ->willReturn($encodedPassword1);

        /** @var Model|\PHPUnit_Framework_MockObject_MockObject $model */
        $model = $this->createMock(Model::class);
        $model->expects($this->once())
            ->method('getOldPassword')
            ->willReturn(self::PASSWORD2);

        $changer = new Changer($entityManager, $passwordEncoder, $user);

        try {
            $changer->changePassword($model);
            $this->fail('Expected exception ' . InvalidPasswordException::class . ' was not thrown');
        } catch (InvalidPasswordException $e) {
            $this->assertEquals('Invalid old password has been provided in password change model', $e->getMessage());
        }
    }

    public function testChangePassword()
    {
        /** @var UserPasswordEncoderInterface $passwordEncoder */
        $passwordEncoder = $this->container->get('security.password_encoder');

        /** @var User|\PHPUnit_Framework_MockObject_MockObject $passwordEncodeUser */
        $passwordEncodeUser = $this->createMock(User::class);
        $passwordEncodeUser->expects($this->once())
            ->method('getSalt')
            ->willReturn(null);
        $encodedPassword1 = $passwordEncoder->encodePassword($passwordEncodeUser, self::PASSWORD1);

        /** @var User|\PHPUnit_Framework_MockObject_MockObject $user */
        $user = $this->createMock(User::class);
        $user->expects($this->once())
            ->method('getPassword')
            ->willReturn($encodedPassword1);
        $user->expects($this->once())
            ->method('setPassword')
            ->with($this->callback(function ($subject) use ($passwordEncoder) {
                /** @var User|\PHPUnit_Framework_MockObject_MockObject $passwordCheckUser */
                $passwordCheckUser = $this->createMock(User::class);
                $passwordCheckUser->expects($this->once())
                    ->method('getSalt')
                    ->willReturn(null);
                $passwordCheckUser->expects($this->once())
                    ->method('getPassword')
                    ->willReturn($subject);
                return $passwordEncoder->isPasswordValid($passwordCheckUser, self::PASSWORD2);
            }));

        /** @var EntityManager|\PHPUnit_Framework_MockObject_MockObject $entityManager */
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('persist')
            ->with($this->equalTo($user));
        $entityManager->expects($this->once())
            ->method('flush');

        /** @var Model|\PHPUnit_Framework_MockObject_MockObject $model */
        $model = $this->createMock(Model::class);
        $model->expects($this->once())
            ->method('getOldPassword')
            ->willReturn(self::PASSWORD1);
        $model->expects($this->once())
            ->method('getNewPassword')
            ->willReturn(self::PASSWORD2);

        $changer = new Changer($entityManager, $passwordEncoder, $user);
        $changer->changePassword($model);
    }
}
