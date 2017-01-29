<?php

namespace AppBundle\Cabinet\PasswordChange;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('oldPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'invalid_message' => 'The old password fields must match.',
            'first_options' => ['label' => 'Old Password'],
            'second_options' => ['label' => 'Repeat Old Password'],
        ]);
        $builder->add('newPassword', RepeatedType::class, [
            'type' => PasswordType::class,
            'required' => true,
            'invalid_message' => 'The new password fields must match.',
            'first_options' => ['label' => 'New Password'],
            'second_options' => ['label' => 'Repeat New Password'],
        ]);
        $builder->add('save', SubmitType::class, ['label' => 'Update']);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Cabinet\PasswordChange\Model',
        ]);
    }

    public function getBlockPrefix()
    {
        return 'password_change_type';
    }
}
