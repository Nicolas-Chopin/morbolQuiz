<?php

namespace App\Form;

use App\Entity\Session;
use App\Form\DataTransformer\AccentSkip;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
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
            ->add('name')
            ->add('aTeamName')
            ->add('bTeamName')
            ->add('aTeamImgUrl')
            ->add('bTeamImgUrl')
            ->add('sorpName')
            ->add('sumName');

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