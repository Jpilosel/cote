<?php

namespace FdjBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CalculeteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cote', NumberType::class,[
//                'required'    => false,
            ])
            ->add('poucentVictoire', NumberType::class,[
//                'required'    => false,
            ])
            ->add('miseEffectue', NumberType::class,[
                'required'    => false,
            ])
            ->add('victoire1OuPerte2', NumberType::class,[
                'required'    => false,
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
    }
}
