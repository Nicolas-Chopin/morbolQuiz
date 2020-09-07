<?php

namespace App\Form;

use App\Entity\Menu;
use App\Entity\Session;
use App\Entity\Category;
use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text')
            ->add('orderInNuggets')
            ->add('orderInSaltpepper')
            ->add('orderInMenu')
            ->add('orderInSum')
            ->add('orderInDeathquiz')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'expanded' => true,
            ])
            ->add('menu', EntityType::class, [
                'class' => Menu::class,
                'placeholder' => 'Aucun',
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