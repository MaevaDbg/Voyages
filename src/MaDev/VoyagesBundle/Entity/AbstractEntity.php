<?php
namespace MaDev\VoyagesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Base Entity
 */
abstract class AbstractEntity
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * @var integer
     * @ORM\Column(type="boolean")
     */
    protected $status;
    
    /**
     * @var Datetime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     * 
     */
    protected $date_creation;
    
    /**
     * @var Datetime
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    protected $date_update;
    
    

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
     * Set status
     *
     * @param integer $status
     * @return AbstractEntity
     */
    public function setStatus($status)
    {
        $this->status = $status;    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set date_creation
     *
     * @param \DateTime $dateCreation
     * @return AbstractEntity
     */
    public function setDateCreation($dateCreation)
    {
        $this->date_creation = $dateCreation;   
        return $this;
    }

    /**
     * Get date_creation
     *
     * @return \DateTime 
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * Set date_update
     *
     * @param \DateTime $dateUpdate
     * @return AbstractEntity
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->date_update = $dateUpdate;  
        return $this;
    }

    /**
     * Get date_update
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->date_update;
    }
}