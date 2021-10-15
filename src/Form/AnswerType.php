<?php

namespace App\Form;

use App\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\NotNull;

class AnswerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', null, [
                'attr' => ['class' => 'col-12 mb-1'],
                'constraints' => new NotBlank(),
                'label' => 'Réponse',
                ])
            ->add('isCorrect', ChoiceType::class, [
                'attr' => ['class' => 'mb-1 d-flex'],
                'constraints' => new NotNull(),
                'label' => 'Cette réponse est-elle correcte ?',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'choice_attr' => [
                    'Oui' => ['class' => 'ml-2'],
                    'Non' => ['class' => 'ml-2'],
                ],
                'expanded' => true,
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Answer::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}