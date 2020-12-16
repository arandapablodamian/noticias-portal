<?php

namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Noticia
 *
 * @ORM\Table(name="noticia")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Noticia
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
   

    /**
     * @var boolean
     *
     * @ORM\Column(name="publicado", type="boolean", nullable=true)
     */
    private $publicado;

    /**
     * @var \DateTime $fechaPublicacion
     * @ORM\Column(name="fechaPublicacion", type="datetime", nullable=true)
     */
    private $fechaPublicacion;

    /**
     * @var string
     *
     * @ORM\Column(name="volanta", type="string", length=255, nullable=true)
     */
    private $volanta;

    /**
     * @var string
     *
     * @ORM\Column(name="titulo", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     */
    private $titulo;

    /**
     * @var string
     *
     * @ORM\Column(name="bajada", type="text", nullable=true)
     */
    private $bajada;

    /**
     * @var string
     *
     * @ORM\Column(name="desarrollo", type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $desarrollo;

    /**
     * @var \DateTime $fechaCreacion
     * @ORM\Column(name="fechaCreacion", type="date", nullable=true)
     */
    private $fechaCreacion;

    /**
     * @var \DateTime $fechaModificacion
     * @ORM\Column(name="fechaModificacion", type="date", nullable=true)
     */
    private $fechaModificacion;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mostrar_titulo", type="boolean", nullable=true)
     */
    private $mostrarTitulo;

    /**
     * @var boolean
     *
     * @ORM\Column(name="mostrar_bajada", type="boolean", nullable=true)
     */
    private $mostrarBajada;

     /**
     * @var boolean
     *
     * @ORM\Column(name="mostrar_volanta", type="boolean", nullable=true)
     */
    private $mostrarVolanta;

    /**
     * @var string
     *
     * @ORM\Column(name="imagen", type="string", length=255, nullable=true)
     */
    private $imagen;



    /**
     * @var string
     *
     * @ORM\Column(name="urlVideo", type="string", length=255, nullable=true)
     * 
     */
    private $urlVideo;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="noticias_images", fileNameProperty="imagen")
     * 
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\OneToMany(targetEntity="\BackendBundle\Entity\Resource", mappedBy="noticia", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $resources;

    /**
     * @ORM\OneToMany(targetEntity="\BackendBundle\Entity\Documento", mappedBy="noticia", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $documentos;

    /**
     * @ORM\OneToMany(targetEntity="\BackendBundle\Entity\AudioResource", mappedBy="noticia", orphanRemoval=true, cascade={"persist", "remove"})
     * @Assert\Valid
     */
    private $audioResources;




    /**
     * @var string
     *
     * @ORM\Column(name="destacada", type="string", nullable=true)
     */
    private $destacada;

/**
     * Many Users have Many Groups.
     * @ORM\ManyToMany(targetEntity="\BackendBundle\Entity\Tag")
     * @ORM\JoinTable(name="tags_x_noticias",
     *      joinColumns={@ORM\JoinColumn(name="noticia_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="tag_id", referencedColumnName="id")}
     *      )
     */
    private $tags;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="color", type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @var string
     *
     * @ORM\Column(name="principal", type="string", length=255, nullable=true)
     */
    private $principal;



    


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->resources = new ArrayCollection();
        $this->documentos = new ArrayCollection();
        $this->tags = new ArrayCollection();

    }

    public function __toString() {
        return $this->getTitulo();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    

    /**
     * Set publicado
     *
     * @param boolean $publicado
     *
     * @return Noticia
     */
    public function setPublicado($publicado)
    {
        $this->publicado = $publicado;

        return $this;
    }

    /**
     * Get publicado
     *
     * @return boolean
     */
    public function getPublicado()
    {
        return $this->publicado;
    }

    /**
     * Set volanta
     *
     * @param string $volanta
     *
     * @return Noticia
     */
    public function setVolanta($volanta)
    {
        $this->volanta = $volanta;

        return $this;
    }

    /**
     * Get volanta
     *
     * @return string
     */
    public function getVolanta()
    {
        return $this->volanta;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     *
     * @return Noticia
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
     * Set bajada
     *
     * @param string $bajada
     *
     * @return Noticia
     */
    public function setBajada($bajada)
    {
        $this->bajada = $bajada;

        return $this;
    }

    /**
     * Get bajada
     *
     * @return string
     */
    public function getBajada()
    {
        return $this->bajada;
    }

    /**
     * Set desarrollo
     *
     * @param string $desarrollo
     *
     * @return Noticia
     */
    public function setDesarrollo($desarrollo)
    {
        $this->desarrollo = $desarrollo;

        return $this;
    }

    /**
     * Get desarrollo
     *
     * @return string
     */
    public function getDesarrollo()
    {
        return $this->desarrollo;
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

    /**
     * Set mostrarTitulo
     *
     * @param boolean $mostrarTitulo
     *
     * @return Noticia
     */
    public function setMostrarTitulo($mostrarTitulo)
    {
        $this->mostrarTitulo = $mostrarTitulo;

        return $this;
    }

    /**
     * Get mostrarTitulo
     *
     * @return boolean
     */
    public function getMostrarTitulo()
    {
        return $this->mostrarTitulo;
    }

    /**
     * Set mostrarBajada
     *
     * @param boolean $mostrarVolanta
     *
     * @return Noticia
     */
    public function setMostrarVolanta($mostrarVolanta)
    {
        $this->mostrarVolanta = $mostrarVolanta;

        return $this;
    }

    /**
     * Get mostrarVolanta
     *
     * @return boolean
     */
    public function getMostrarVolanta()
    {
        return $this->mostrarVolanta;
    }

    /**
     * Set mostrarBajada
     *
     * @param boolean $mostrarBajada
     *
     * @return Noticia
     */
    public function setMostrarBajada($mostrarBajada)
    {
        $this->mostrarBajada = $mostrarBajada;

        return $this;
    }

    /**
     * Get mostrarBajada
     *
     * @return boolean
     */
    public function getMostrarBajada()
    {
        return $this->mostrarBajada;
    }


    /**
     * Set imagen
     *
     * @param string $imagen
     *
     * @return Noticia
     */
    public function setImagen($imagen)
    {
        $this->imagen = $imagen;

        return $this;
    }

    /**
     * Get imagen
     *
     * @return string
     */
    public function getImagen()
    {
        return $this->imagen;
    }

    

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the  update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Product
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;

        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * Add resource
     *
     * @param \BackendBundle\Entity\Resource $resource
     *
     * @return Noticia
     */
    public function addResource(\BackendBundle\Entity\Resource $resource)
    {
        $resource->setNoticia($this);
        $this->resources[] = $resource;

        return $this;
    }

    /**
     * Remove resource
     *
     * @param \BackendBundle\Entity\Resource $resource
     */
    public function removeResource(\BackendBundle\Entity\Resource $resource)
    {
        $this->resources->removeElement($resource);
    }

    /**
     * Get resources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * Add documento
     *
     * @param \BackendBundle\Entity\Documento $documento
     *
     * @return Noticia
     */
    public function addDocumento(\BackendBundle\Entity\Documento $documento)
    {
        $documento->setNoticia($this);
        $this->documentos[] = $documento;

        return $this;
    }

    /**
     * Remove documento
     *
     * @param \BackendBundle\Entity\Documento $documento
     */
    public function removeDocumento(\BackendBundle\Entity\Documento $documento)
    {
        $this->documentos->removeElement($documento);
    }

    /**
     * Get documentos
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocumentos()
    {
        return $this->documentos;
    }




    
     /**
     * Set destacada
     *
     * @param string $destacada
     *
     * @return Noticia
     */
    public function setDestacada($destacada)
    {
        $this->destacada = $destacada;

        return $this;
    }

    /**
     * Get destacada
     *
     * @return string
     */
    public function getDestacada()
    {
        return $this->destacada;
    }



    /**
     * Add tag
     *
     * @param \BackendBundle\Entity\TagNoticia $tag
     *
     * @return Noticia
     */
    public function addTag(\BackendBundle\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \BackendBundle\Entity\Tag $tag
     */
    public function removeTag(\BackendBundle\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tag
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }



    /**
     * Set urlVideo
     *
     * @param string $urlVideo
     *
     * @return Noticia
     */
    public function setUrlVideo($urlVideo)
    {
        $this->urlVideo = $urlVideo;

        return $this;
    }

    /**
     * Get urlVideo
     *
     * @return string
     */
    public function getUrlVideo()
    {
        return $this->urlVideo;
    }

      /**
     * Set color
     *
     * @param string $color
     *
     * @return Noticia
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }


     /**
     * Set principal
     *
     * @param string $principal
     *
     * @return Noticia
     */
    public function setPrincipal($principal)
    {
        $this->principal = $principal;

        return $this;
    }

    /**
     * Get principal
     *
     * @return string
     */
    public function getPrincipal()
    {
        return $this->principal;
    }


    /**
     * Add audioResource
     *
     * @param \BackendBundle\Entity\AudioResources $audioResource
     *
     * @return Noticia
     */
    public function addAudioResource(\BackendBundle\Entity\AudioResource $audioResource)
    {
        $audioResource->setNoticia($this);
        $this->audioResources[] = $audioResource;

        return $this;
    }

    /**
     * Remove audioResource
     *
     * @param \BackendBundle\Entity\AudioResource $audioResource
     */
    public function removeAudioResource(\BackendBundle\Entity\AudioResource $audioResource)
    {
        $this->audioResources->removeElement($audioResource);
    }

    /**
     * Get audioResources
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAudioResources()
    {
        return $this->audioResources;
    }

    /**
     * Set fechaPublicacion
     *
     * @param \DateTime $fechaPublicacion
     *
     * @return Noticia
     */
    public function setFechaPublicacion($fechaPublicacion)
    {
        $this->fechaPublicacion = $fechaPublicacion;

        return $this;
    }

    /**
     * Get fechaPublicacion
     *
     * @return \DateTime
     */
    public function getFechaPublicacion()
    {
        return $this->fechaPublicacion;
    }
}
