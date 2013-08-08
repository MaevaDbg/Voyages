<?php

namespace MaDev\VoyagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="MaDev\VoyagesBundle\Repository\CountryRepository")
 */
class Country extends AbstractPlace {

    /**
     * @ORM\OneToMany(targetEntity="City", mappedBy="country")  
     */
    protected $cities;

    public function __construct() {
        $this->cities = new ArrayCollection();
    }

    /**
     * Add cities
     *
     * @param City $city
     * @return Country
     */
    public function addCity(City $city) {
        $city->setCountry($this);
        $this->cities[] = $city;
        return $this;
    }

    /**
     * Remove cities
     *
     * @param City $city
     * @return Country
     */
    public function removeCity(City $city) {
        $city->setCountry(null);
        $this->cities->removeElement($city);
        return $this;
    }

    /**
     * Get cities
     *
     * @return ArrayCollection 
     */
    public function getCities() {
        return $this->cities;
    }

}