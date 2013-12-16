<?php

namespace MaDev\VoyagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use MaDev\UploadFileBundle\Entity\File;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MaDev\VoyagesBundle\Repository\CityRepository")
 */
class City extends AbstractPlace
{

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $country;

    /**
     *
     * @ORM\OneToMany(targetEntity="MaDev\UploadFileBundle\Entity\File", mappedBy="city", cascade={"persist", "remove", "merge"})
     */
    protected $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * Set country
     *
     * @param Country $country
     * @return City
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return Country 
     */
    public function getCountry()
    {
        return $this->country;
    }

    public function addImage(File $image)
    {
        $image->setCity($this);
        $this->images[] = $image;
        return $this;
    }

    public function removeImage(File $image)
    {
        $image->setCity(null);
        $this->images->removeElement($image);
    }

    public function getImage()
    {
        return $this->images;
    }

}