<?php
namespace MaDev\VoyagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Country extends AbstractPlace
{
    protected $home_image;
    protected $map;
}