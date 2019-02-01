<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AbstractGMapRepository")
 */
class AbstractGMap {

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adress;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $longitude;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="boolean")
     */
    private $publicated;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    public function getId() {
        return $this->id;
    }

    public function getAdress() {
        return $this->adress;
    }

    public function setAdress($adress) {
        $this->adress = $adress;

        return $this;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;

        return $this;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;

        return $this;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;

        return $this;
    }

    public function getCreatedAt() {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt) {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt() {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt) {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCommentaire() {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire) {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPublicated() {
        return $this->publicated;
    }

    public function setPublicated($publicated) {
        $this->publicated = $publicated;

        return $this;
    }

    public function getEtat() {
        return $this->etat;
    }

    public function setEtat($etat) {
        $this->etat = $etat;

        return $this;
    }

    public function getPhoto() {
        return $this->photo;
    }

    public function setPhoto($photo) {
        $this->photo = $photo;

        return $this;
    }

}
