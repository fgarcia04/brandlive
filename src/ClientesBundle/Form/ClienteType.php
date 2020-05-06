<?php

namespace ClientesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClienteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('apellido')
            ->add('email', 'email')
            ->add('grupoCliente', 'choice', array(
                'choices'   => array('' => 'Seleccionar un grupo',1 => 'Grupo A', 2 => 'Grupo B', 3 => 'Grupo C')
            ))
            ->add('observaciones')
            ->add('save','submit', array('label' => 'Guardar'));
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ClientesBundle\Entity\Cliente'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'cliente';
    }


}
