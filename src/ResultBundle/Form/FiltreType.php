<?php

namespace ResultBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use ResultBundle\Entity\Resultat;

class FiltreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbResult', ChoiceType::class, [
                'choices'=> [
                    '2'=>'2',
                    '3'=>'3',
                ]
            ])
            ->add('sport', ChoiceType::class, [
                'choices'=> [
                    'Tennis'=>'Tennis',
                    'Foot'=>'Foot',
                    'Hokey'=>'Hokey',
                    'Basket'=>'Basket',
                    'Rugby'=>'Rugby',
                ],
                'required'=> false,
            ])
            ->add('sexe', ChoiceType::class, [
                'choices'=> [
                    'H'=>'H',
                    'F'=>'F',
                ],
                'required'=> false,
            ])
            ->add('cote', NumberType::class, [
                'required'=> false,
            ])
//            ->add('min', NumberType::class, [
//                'required'=> false,
//            ])
//            ->add('max', NumberType::class, [
//                'required'=> false,
//            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }


    public function getName()
    {
        return 'resultbundle_resultat';
    }
}
