<?php

namespace MaDev\UploadFileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use MaDev\VoyagesBundle\Entity\City;

/**
 * File
 * 
 * @ORM\Entity(repositoryClass="MaDev\UploadFileBundle\Repository\FileRepository")
 * 
 */
class File {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * 
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $name;

    /**
     * 
     * @var text
     * @ORM\Column(type="string", length=255)
     */
    protected $directory;
    
    /**
     *
     * @var text
     */
    protected $new_directory;

    /**
     *
     * @var integer
     * @ORM\Column(type="integer", name="order_list", nullable=true)
     */
    protected $order;

    /**
     *
     * @var text
     * @ORM\Column(type="text", nullable=true)
     * 
     */
    protected $description;
    
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
     *
     * @ORM\ManyToOne(targetEntity="MaDev\VoyagesBundle\Entity\City", inversedBy="images")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $city;
    

    public function __toString() {
        return $this->getDirectory()."/".$this->getThumbnail();
    }

        /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return File
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName() {
        return $this->name;
    }
   
    /**
     * Set directory
     *
     * @param string $directory
     * @return File
     */
    public function setDirectory($directory) {
        $this->directory = $directory;
        return $this;
    }

    /**
     * Get directory
     *
     * @return string 
     */
    public function getDirectory() {
        return $this->directory;
    }
    
    /**
     * Set new directory
     *
     * @param string $new_directory
     * @return File
     */
    public function setNewDirectory($new_directory) {
        $this->new_directory = $new_directory;
        return $this;
    }

    /**
     * Get new directory
     *
     * @return string 
     */
    public function getNewDirectory() {
        return $this->new_directory;
    }

    /**
     * Set order
     *
     * @param string $order
     * @return File
     */
    public function setOrder($order) {
        $this->order = $order;
        return $this;
    }

    /**
     * Get order
     *
     * @return integer 
     */
    public function getOrder() {
        return $this->order;
    }

    /**
     * Set description
     *
     * @param text $description
     * @return File
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * Set date_creation
     *
     * @param \DateTime $dateCreation
     * @return File
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
     * @return File
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
    
    /**
     * Set city
     *
     * @param City $city
     * @return File
     */
    public function setCity(City $city = null){
        $this->city = $city;
        return $this;
    }

}