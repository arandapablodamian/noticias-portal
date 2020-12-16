<?php
namespace BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Documento
 *
 * @ORM\Table(name="documento")
 * @ORM\Entity
 * @Vich\Uploadable
 */
class Documento
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
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255, nullable=true)
     */
    private $path;

    /**
     * @var string
     *
     * @ORM\Column(name="epigrafe", type="text", nullable=true)
     */
    private $epigrafe;

 
    /**
     * @var \SubCC\PaginasBundle\Entity\Noticia
     *
     * @ORM\ManyToOne(targetEntity="BackendBundle\Entity\Noticia", inversedBy="documentos")
     * @ORM\JoinColumn(name="noticia_id", referencedColumnName="id")
     */
    private $noticia;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="documentos_image", fileNameProperty="path")
     * 
     * @var File
     * @Assert\File(
     *     maxSize = "15M",
     *     mimeTypesMessage = "Solo se permiten documentos PDF y archivos docx"
     * )
     */
    private $imageFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     * @Assert\NotNull
     */
    private $updatedAt;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->updatedAt = new \DateTime('now');
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
     * Set path
     *
     * @param string $path
     *
     * @return Documento
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set epigrafe
     *
     * @param string $epigrafe
     *
     * @return Documento
     */
    public function setEpigrafe($epigrafe)
    {
        $this->epigrafe = $epigrafe;

        return $this;
    }

    /**
     * Get epigrafe
     *
     * @return string
     */
    public function getEpigrafe()
    {
        return $this->epigrafe;
    }

    /**
     * Set noticia
     *
     * @param \SubCC\PaginasBundle\Entity\Noticia $noticia
     *
     * @return Documento
     */
    public function setNoticia(\BackendBundle\Entity\Noticia $noticia = null)
    {
        $this->noticia = $noticia;

        return $this;
    }

    /**
     * Get noticia
     *
     * @return \SubCC\PaginasBundle\Entity\Noticia
     */
    public function getNoticia()
    {
        return $this->noticia;
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
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Documento
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
