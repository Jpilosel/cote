<?php

namespace FdjBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormulesType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('eventId')->add('indexP')->add('sportId')->add('marketType')->add('marketTypeGroup')->add('marketTypeId')->add('marketId')->add('label')->add('competition')->add('competitionId')->add('end')->add('un')->add('n')->add('deux')        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FdjBundle\Entity\Formules'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fdjbundle_formules';
    }


}
