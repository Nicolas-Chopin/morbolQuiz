<?php

namespace App\Form;

use App\Entity\Session;
use App\Form\DataTransformer\AccentSkip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
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
            'label' => 'Nom de la partie',
            'attr' => ['class' => 'col-12 mb-2'],
            'constraints' => new NotBlank(),
            ])
            ->add('aTeamName', null, [
                'label' => 'Nom de l\'équipe 1',
                'attr' => ['class' => 'col-12 mb-2 text-danger'],
                'constraints' => new NotBlank(),
                ])
            ->add('aPlayerOne', null, [
                'label' => "Joueur 1 (chef d'équipe)",
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('aPlayerTwo', null, [
                'label' => "Joueur 2",
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('aPlayerThree', null, [
                'label' => "Joueur 3",
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('bTeamName', null, [
                'label' => 'Nom de l\'équipe 2',
                'attr' => ['class' => 'col-12 mb-2 text-warning'],
                'constraints' => new NotBlank(),
                ])
            ->add('bPlayerOne', null, [
                'label' => "Joueur 1 (chef d'équipe)",
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('bPlayerTwo', null, [
                'label' => "Joueur 2",
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('bPlayerThree', null, [
                'label' => "Joueur 3",
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('aTeamImgUrl', null, [
                'label' => 'Image de l\'équipe 1',
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('bTeamImgUrl', null, [
                'label' => 'Image de l\'équipe 2',
                'attr' => ['class' => 'col-12 mb-2'],
                ])
            ->add('sorpName', null, [
                'label' => 'Thème du Sel ou poivre',
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                ])
            ->add('sumName', null, [
                'label' => 'Thème de l\'addition',
                'attr' => ['class' => 'col-12 mb-2'],
                'constraints' => new NotBlank(),
                ]);

        $builder->get('name')
            ->addModelTransformer($this->accentSkip);
        $builder->get('aTeamName')
            ->addModelTransformer($this->accentSkip);
        $builder->get('bTeamName')
            ->addModelTransformer($this->accentSkip);
        $builder->get('sorpName')
            ->addModelTransformer($this->accentSkip);
        $builder->get('sumName')
            ->addModelTransformer($this->accentSkip);
        $builder->get('aPlayerOne')
            ->addModelTransformer($this->accentSkip);
        $builder->get('aPlayerTwo')
            ->addModelTransformer($this->accentSkip);
        $builder->get('aPlayerThree')
            ->addModelTransformer($this->accentSkip);
        $builder->get('bPlayerOne')
            ->addModelTransformer($this->accentSkip);
        $builder->get('bPlayerTwo')
            ->addModelTransformer($this->accentSkip);
        $builder->get('bPlayerThree')
            ->addModelTransformer($this->accentSkip);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
            'attr' => [
                'novalidate' => 'novalidate'
            ],
        ]);
    }
}