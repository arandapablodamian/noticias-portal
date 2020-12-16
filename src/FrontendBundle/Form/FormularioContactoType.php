<?php

namespace FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;

use FrontendBundle\Entity\FormularioContacto;

class FormularioContactoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('nomyap',TextType::class,array('label'=>'Nombre y Apellido'))
            ->add('email',EmailType::class,array( 'label' => 'Email'))
            ->add('telefono',TextType::class,array( 'invalid_message' => 'Ingresaste un número de teléfono no válido','label' => 'Teléfono', 'attr'=>array('type'=>'number')))
            ->add('mensaje',TextareaType::class, [
                'attr'=>['rows'=>10 , 'cols'=>50],
                'label' => 'Mensaje'
            ])
            ->add('enviar', SubmitType::class, array(
                'label' => 'Enviar'
            ))
            //  ->add('limpiar', ResetType::class, array(
            //     'label' => 'Limpiar'
            // )
            //  );
        ;
    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => FormularioContacto::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontendbundle_formulariocontacto';
    }


}
