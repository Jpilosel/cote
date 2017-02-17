<?php

namespace FdjBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TennisScore2Type extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbSetGagnant', ChoiceType::class, [
                'choices' => [
                    2 => '2',
                    3 => '3',
                    4 => '4',
                    5 => '5',
                ],])
            ->add('cote')
                

        ;
    }
    

    public function configureOptions(OptionsResolver $resolver)
    {

    }


    public function getBlockPrefix()
    {
        return 'fdjbundle_tennisscore2';
    }


}
