<?php

namespace App\Form;

use App\Entity\Menu;
use App\Form\DataTransformer\AccentSkip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MenuType extends AbstractType
{
    private $accentSkip;

    public function __construct(AccentSkip $accentSkip)
    {
        $this->accentSkip = $accentSkip;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Nom du germe',
                ])
            ->add('menuOrder', null, [
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                'label' => 'Position du germe',
                ]);
            
            $builder->get('name')
                ->addModelTransformer($this->accentSkip);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Menu::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}