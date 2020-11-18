<?php

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionSorpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', null, [
                'attr' => ['class' => 'mb-1'],
                'constraints' => new NotBlank(),
                'label' => 'Intitulé de la question',
                ])
            ->add('orderInSaltpepper', null, [
                'attr' => ['class' => 'mb-1'],
                'constraints' => new NotBlank(),
                'label' => 'Numéro de la question',
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}