<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Prénom*',
                ])
            ->add('lastname', null, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Nom*',
                ])
            ->add('phone', null, [
                'attr' => ['class' => 'col-12 mb-2'],
                'label' => 'Téléphone (optionnel)',
                ])
            ->add('email', null, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Mail*',
                ])
            ->add('message', TextareaType::class, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Message*',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'attr' => ['novalidate' => 'novalidate'],
        ]);
    }
}
