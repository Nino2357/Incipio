<?php

/*
 * This file is part of the Incipio package.
 *
 * (c) Florian Lefevre
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace mgate\TresoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BaseURSSAFType extends AbstractType
{
    public function buildForm(\Symfony\Component\Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('baseURSSAF', 'money', array('label' => 'Base en Euro', 'required' => true))
            ->add('dateDebut', 'genemu_jquerydate', array('label' => 'Applicable du', 'required' => true, 'widget' => 'single_text'))
            ->add('dateFin', 'genemu_jquerydate', array('label' => 'Applicable au', 'required' => true, 'widget' => 'single_text'));
    }

    public function getName()
    {
        return 'mgate_tresobundle_baseurssaftype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'mgate\TresoBundle\Entity\BaseURSSAF',
        ));
    }
}