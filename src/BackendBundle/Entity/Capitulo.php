<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Capitulo
 *
 * @ORM\Table(name="capitulo")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Capitulo
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

      /**
     * @var string
     *
     * @ORM\Column(name="nro_capitulo", type="integer")
     */
    private $nroCapitulo;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255)
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="video", type="string", length=255)
     */
    private $video;


    /**
     * @var bool
     *
     * @ORM\Column(name="publicado", type="boolean")
     */
    private $publicado;


    /**
    * @ORM\ManyToOne(targetEntity="\BackendBundle\Entity\Programa", inversedBy="capitulos")
    * @ORM\JoinColumn(name="programa_id", referencedColumnName="id")
    */
    protected $programa;

  

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \DateTime $fechaCreacion
     * @ORM\Column(name="fechaCreacion", type="date")
     */
    private $fechaCreacion;

    /**
     * @var \DateTime $fechaModificacion
     * @ORM\Column(name="fechaModificacion", type="date", nullable=true)
     */
    private $fechaModificacion;


    public function __toString() {
        return $this->titulo;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

     /**
     * Set nroCapitulo
     *
     * @param integer $nroCapitulo
     *
     * @return Capitulo
     */
    public function setNroCapitulo($nroCapitulo)
    {
        $this->nroCapitulo = $nroCapitulo;

        return $this;
    }

    /**
     * Get nroCapitulo
     *
     * @return integer
     */
    public function getNroCapitulo()
    {
        return $this->nroCapitulo;
    }


    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Capitulo
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set video
     *
     * @param string $video
     *
     * @return Capitulo
     */
    public function setVideo($video)
    {
        $this->video = $video;

        return $this;
    }

    /**
     * Get video
     *
     * @return string
     */
    public function getVideo()
    {
        return $this->video;
    }
    /**
     * Set publicado
     *
     * @param boolean $publicado
     *
     * @return Capitulo
     */
    public function setPublicado($publicado)
    {
        $this->publicado = $publicado;

        return $this;
    }

    /**
     * Get publicado
     *
     * @return bool
     */
    public function getPublicado()
    {
        return $this->publicado;
    }

   
    /**
     * Set programa
     *
     * @param \Backend\Entity\Programa $programa
     *
     * @return Capitulo
     */
    public function setPrograma(\BackendBundle\Entity\Programa $programa = null)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return \Backend\Entity\Programa
     */
    public function getPrograma()
    {
        return $this->programa;
    }


     /**
     * Set fechaCreacion
     *
     * @param \DateTime $fechaCreacion
     *
     * @return Noticia
     */
    public function setFechaCreacion($fechaCreacion)
    {
        $this->fechaCreacion = $fechaCreacion;

        return $this;
    }

    /**
     * Get fechaCreacion
     *
     * @return \DateTime
     */
    public function getFechaCreacion()
    {
        return $this->fechaCreacion;
    }


    /**
     * Set fechaModificacion
     *
     * @param \DateTime $fechaModificacion
     *
     * @return Noticia
     */
    public function setFechaModificacion($fechaModificacion)
    {
        $this->fechaModificacion = $fechaModificacion;

        return $this;
    }

    /**
     * Get fechaModificacion
     *
     * @return \DateTime
     */
    public function getFechaModificacion()
    {
        return $this->fechaModificacion;
    }

}
