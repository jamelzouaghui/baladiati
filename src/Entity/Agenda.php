<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;
use JMS\Serializer\Annotation as JMS;


/**
 * @ORM\Entity(repositoryClass="App\Repository\AgendaRepository")
 * @JMS\ExclusionPolicy("all")
 * @ORM\HasLifecycleCallbacks
 * @ORM\MappedSuperclass
 */
class Agenda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $adress;
    
 

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreation;

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle( $title)
    {
        $this->title = $title;

        return $this;
    }

    public function getAdress()
    {
        return $this->adress;
    }

    public function setAdress( $adress)
    {
        $this->adress = $adress;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt( $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt( $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
     /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updatedTimestamps() {
        $dateTimeNow = new \DateTime('now');
        $this->setUpdatedAt($dateTimeNow);
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt($dateTimeNow);
        }
    }

    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    public function setDateCreation( $dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }
}
