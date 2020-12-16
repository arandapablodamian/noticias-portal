<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToMany(targetEntity="BackendBundle\Entity\Group")
     * @ORM\JoinTable(name="user_group",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    /**
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    protected $nombre;

    /**
     * @ORM\Column(name="apellido", type="string", length=255)
     */
    protected $apellido;

    /**
     * @ORM\Column(name="direccion", type="string", length=255,nullable=true)
     */
    protected $direccion;

    /**
     * @ORM\Column(name="telefonoContacto1", type="string", length=255, nullable=true)
     */
    protected $telefonoContacto1;

    /**
     * @ORM\Column(name="telefonoContacto2", type="string", length=255, nullable=true)
     */
    protected $telefonoContacto2;



 


    public function __construct()
    {
        parent::__construct();
    }

    public function __toString() {
        return $this->nombre." ".$this->apellido;
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

  

    /**
     * Set nombre
     *
     * @param string $nombre
     *
     * @return User
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set apellido
     *
     * @param string $apellido
     *
     * @return User
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    
    /**
     * Set direccion
     *
     * @param string $direccion
     *
     * @return User
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string
     */
    public function getDireccion()
    {
        return $this->direccion;
    }


    /**
     * Set telefonoContacto1
     *
     * @param string $telefonoContacto1
     *
     * @return User
     */
    public function setTelefonoContacto1($telefonoContacto1)
    {
        $this->telefonoContacto1 = $telefonoContacto1;

        return $this;
    }

    /**
     * Get telefonoContacto1
     *
     * @return string
     */
    public function getTelefonoContacto1()
    {
        return $this->telefonoContacto1;
    }

        /**
     * Set phone
     *
     * @param string $telefonoContacto2
     *
     * @return User
     */
    public function setTelefonoContacto2($telefonoContacto2)
    {
        $this->telefonoContacto2 = $telefonoContacto2;

        return $this;
    }

    /**
     * Get telefonoContacto2
     *
     * @return string
     */
    public function getTelefonoContacto2()
    {
        return $this->telefonoContacto2;
    }

    public function getNombreCompleto()
    {
        return $this->getApellido().', '.$this->getNombre();
    }
}
