<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class LoginType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', null, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Identifiant',
                ])
            ->add('_password', PasswordType::class, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Mot de passe',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            //'action' => '/login',
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
