<?php

namespace FdjBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JoueurTennisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomJoueur')
//            ->add('cote')
//            ->add('sport', ChoiceType::class, [
//                'choices' => [
//                    100 => 'foot',
//                    601600 => 'basket',
//                    600 => 'tennis',
//                    964500 => 'rugby',
//                    1200 => 'volley',
//                    1100 => 'hand',
//                    2100 => 'hockey',
//                    700 => 'foot us',
//                ],
//                'required'    => false,
//            ])
//            ->add('typeResultat',ChoiceType::class, [
//                'choices' => [
//                    1 => '1/N/2',
//                    12 =>'1/N/2_QT',
//                    21=>'Equipe qui va se qualifier',
//                    29=>'Face à Face_Set',
//                    3=>'Handicap',
//                    6 =>'double chance',
//                    9=>'1er but',
//                ],
//                'required'    => false,
//            ])


        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {

    }

    public function getBlockPrefix()
    {
        return 'fdj_bundle_cote_list_type';
    }
}
