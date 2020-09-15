<?php

namespace App\Form;

use App\Entity\Role;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', null, [
                'constraints' => new NotBlank,
                'label' => 'Identifiant',
                'attr' => ['class' => 'col-12 mb-2'],
            ])
            ->add('password', PasswordType::class, [
                'constraints' => new NotBlank,
                'label' => 'Mot de passe',
                'attr' => ['class' => 'col-12 mb-2'],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Email,
                    new NotBlank,
                    'attr' => ['class' => 'col-12 mb-2'],
                ],
                'attr' => ['class' => 'col-12 mb-2'],
                'label' => 'Adresse mail',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
