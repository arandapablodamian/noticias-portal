<?php

namespace FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use FrontendBundle\Entity\FormularioBusqueda;

class FormularioBusquedaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setMethod('POST')
            ->add('titulo',TextType::class, array(
                'label'=>'Contenido',
                 
                  // adds a class that can be selected in JavaScript
                
              ))
               ->add('fechaDesde', TextType::class, array(
                'label'=>'fechaDesde',
                 

                  // adds a class that can be selected in JavaScript
                  'attr' => ['class' => 'js-datepicker','col' => 'col-md-2'],
              ))
               ->add('fechaHasta', TextType::class, array(
                'label'=>'fechaHasta',
                 

                  // adds a class that can be selected in JavaScript
                  'attr' => ['class' => 'js-datepicker','col' => 'col-md-2'],
              ))

               ->add('enviar', SubmitType::class, array(
                        'label' => 'Buscar',
                        'attr' => ['col' => 'col-md-2'],

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
            'data_class' => FormularioBusqueda::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'frontendbundle_formulariobusqueda';
    }


}
