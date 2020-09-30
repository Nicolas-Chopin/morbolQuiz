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
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Réponse',
                ])
            ->add('answerOrder', IntegerType::class, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Numéro/ordre de la réponse',
                ])
            ->add('isCorrect', ChoiceType::class, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotNull(),
                'label' => 'Cette réponse est correcte',
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'expanded' => true
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