<?php

namespace MaDev\UploadFileBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $thumbnail;

    /**
     * 
     * @var text
     * @ORM\Column(type="string", length=255)
     */
    protected $path;

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
     * Set thumbnail
     *
     * @param string $thumbnail
     * @return File
     */
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    /**
     * Get thumbnail
     *
     * @return string 
     */
    public function getThumbnail() {
        return $this->thumbnail;
    }

    /**
     * Set path
     *
     * @param string $path
     * @return File
     */
    public function setPath($path) {
        $this->path = $path;
        return $this;
    }

    /**
     * Get path
     *
     * @return string 
     */
    public function getPath() {
        return $this->path;
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

}