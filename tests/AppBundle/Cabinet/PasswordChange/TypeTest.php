<?php

namespace Tests\AppBundle\Cabinet\PasswordChange;

use AppBundle\Cabinet\PasswordChange\Model;
use AppBundle\Cabinet\PasswordChange\Type;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class TypeTest extends TypeTestCase
{
    protected function getExtensions()
    {
        return [
            new ValidatorExtension(Validation::createValidator())
        ];
    }

    public function testBuildForm()
    {
        $formData = [
            'oldPassword' => [
                'first' => '123123',
                'second' => '123123',
            ],
            'newPassword' => [
                'first' => '321321',
                'second' => '321321',
            ],
        ];

        $form = $this->factory->create(Type::class);
        $form->submit($formData);

        $object = new Model();
        $object->setOldPassword($formData['oldPassword']['first']);
        $object->setNewPassword($formData['newPassword']['first']);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach ($formData as $key => $value) {
            $this->assertArrayHasKey($key, $children);
        }
    }
}
