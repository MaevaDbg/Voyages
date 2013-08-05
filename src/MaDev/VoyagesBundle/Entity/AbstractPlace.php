<?php
namespace MaDev\VoyagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Place
 * 
 * @ORM\Entity
 * @ORM\Table(name="place")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({"country" = "Country", "city" = "City"})
 */
abstract class AbstractPlace extends AbstractEntity
{
    /**
     * @var string
     * @ORM\Column(type="string", length=250, nullable=false) 
     * @Assert\NotBlank()
     */
    protected $name;
    
    /**
     * @var string
     * @ORM\Column(type="string", length=250, nullable=false)
     * @Gedmo\Slug(fields={"name"}, updatable=false, separator="_")
     */
    protected $slug;
    
    /**
     * @var text
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;
    
    /**
     * @var datetime
     * @ORM\Column(type="date", nullable=true)
     * @Assert\NotBlank()
     */
    protected $visite_date;
    
    /**
     * Set name
     *
     * @param string $name
     * @return AbstractPlace
     */
    public function setName($name)
    {
        $this->name = $name;   
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return AbstractPlace
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;   
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return AbstractPlace
     */
    public function setDescription($description)
    {
        $this->description = $description;    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set visite_date
     *
     * @param \DateTime $visiteDate
     * @return AbstractPlace
     */
    public function setVisiteDate($visiteDate)
    {
        $this->visite_date = $visiteDate;
        return $this;
    }

    /**
     * Get visite_date
     *
     * @return \DateTime 
     */
    public function getVisiteDate()
    {
        return $this->visite_date;
    }

}