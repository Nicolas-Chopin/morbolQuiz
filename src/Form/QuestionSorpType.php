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
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Intitulé de la question',
                ])
            ->add('orderInSaltpepper', null, [
                'attr' => ['class' => 'col-12 mb-2'],
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