<?php

namespace FrontendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class FormularioBusqueda
{
    /**
     * @Assert\NotBlank(message="El campo no debe estar vacio")
     */
    public $titulo;

    /**
    * @Assert\NotBlank(message="El campo no debe estar vacio")
    
     */
    public $fechaDesde;


    /**
     * @Assert\NotBlank(message="El campo no debe estar vacio")
     
     */
    public $fechaHasta;

  
}
