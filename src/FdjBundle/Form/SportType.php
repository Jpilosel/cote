<?php

namespace FdjBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SportType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventId')->add('marketId')->add('hasCombiBonus')->add('sportId')->add('indexP')->add('marketType')->add('marketTypeGroup')->add('marketTypeId')->add('end')->add('label')->add('eventType')->add('competition')->add('competitionId')->add('nbMarkets')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FdjBundle\Entity\Sport'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fdjbundle_sport';
    }


}
