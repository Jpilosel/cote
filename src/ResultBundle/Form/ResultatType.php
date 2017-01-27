<?php

namespace ResultBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResultatType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbResult')
            ->add('sport')
            ->add('sexe')
            ->add('date', 'date')
            ->add('competition')
            ->add('rencontre')
            ->add('equipe1')
            ->add('cote1')
            ->add('coteNull')
            ->add('equipe2')
            ->add('cote2')
            ->add('resultat')
            ->add('coteGagnante')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ResultBundle\Entity\Resultat'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'resultbundle_resultat';
    }


}
