<?php

namespace MaDev\VoyagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class City extends AbstractPlace {

    /**
     * @ORM\ManyToOne(targetEntity="Country", inversedBy="cities")
     */
    protected $country;

    /**
     * Set country
     *
     * @param Country $country
     * @return City
     */
    public function setCountry(Country $country = null) {
        $this->country = $country;
        return $this;
    }

    /**
     * Get country
     *
     * @return Country 
     */
    public function getCountry() {
        return $this->country;
    }

}