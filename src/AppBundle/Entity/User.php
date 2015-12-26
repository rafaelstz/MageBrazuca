<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 *
 * @author Matheus Gontijo <matheus@matheusgontijo.com>
 */
class User implements Entity
{
    /**
     * @var int
     */
    const GENDER_MALE   = 1;

    /**
     * @var int
     */
    const GENDER_FEMALE = 2;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=80)
     * @var string
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=80)
     * @var string
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=80, unique=true)
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=45, unique=true)
     * @var string
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=80)
     * @var string
     */
    private $password;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $about;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $picturePath;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $location;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $locationCityShort;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $locationCityLong;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $locationStateShort;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $locationStateLong;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $locationCountryShort;

    /**
     * @ORM\Column(type="string")
     * @var string
     */
    private $locationCountryLong;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $gender;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $company;

    /**
     * @ORM\Column(type="integer", options={"default" = 0})
     * @var int
     */
    private $isAvailableToHiring;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $contactWebsite;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $contactTwitter;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $contactLinkedIn;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $contactCertification;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $contactGitHub;

    /**
     * @ORM\Column(type="string", nullable=true)
     * @var string
     */
    private $contactStackOverflow;

    /**
     * @var int
     */
    private $upvoteTotal;

    /**
     * @ORM\Column(type="datetime")
     * @var DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param string $about
     */
    public function setAbout($about)
    {
        $this->about = $about;
    }

    /**
     * @return string
     */
    public function getPicturePath()
    {
        return $this->picturePath;
    }

    /**
     * @param string $picturePath
     */
    public function setPicturePath($picturePath)
    {
        $this->picturePath = $picturePath;
    }

    /**
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
    }

    /**
     * @param string $location
     */
    public function setLocation($location)
    {
        $this->location = $location;
    }

    /**
     * @return string
     */
    public function getLocationCityShort()
    {
        return $this->locationCityShort;
    }

    /**
     * @param string $locationCityShort
     */
    public function setLocationCityShort($locationCityShort)
    {
        $this->locationCityShort = $locationCityShort;
    }

    /**
     * @return string
     */
    public function getLocationCityLong()
    {
        return $this->locationCityLong;
    }

    /**
     * @param string $locationCityLong
     */
    public function setLocationCityLong($locationCityLong)
    {
        $this->locationCityLong = $locationCityLong;
    }

    /**
     * @return string
     */
    public function getLocationStateShort()
    {
        return $this->locationStateShort;
    }

    /**
     * @param string $locationStateShort
     */
    public function setLocationStateShort($locationStateShort)
    {
        $this->locationStateShort = $locationStateShort;
    }

    /**
     * @return string
     */
    public function getLocationStateLong()
    {
        return $this->locationStateLong;
    }

    /**
     * @param string $locationStateLong
     */
    public function setLocationStateLong($locationStateLong)
    {
        $this->locationStateLong = $locationStateLong;
    }

    /**
     * @return string
     */
    public function getLocationCountryShort()
    {
        return $this->locationCountryShort;
    }

    /**
     * @param string $locationCountryShort
     */
    public function setLocationCountryShort($locationCountryShort)
    {
        $this->locationCountryShort = $locationCountryShort;
    }

    /**
     * @return string
     */
    public function getLocationCountryLong()
    {
        return $this->locationCountryLong;
    }

    /**
     * @param string $locationCountryLong
     */
    public function setLocationCountryLong($locationCountryLong)
    {
        $this->locationCountryLong = $locationCountryLong;
    }

    /**
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     */
    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return int
     */
    public function getIsAvailableToHiring()
    {
        return $this->isAvailableToHiring;
    }

    /**
     * @param int $isAvailableToHiring
     */
    public function setIsAvailableToHiring($isAvailableToHiring)
    {
        $this->isAvailableToHiring = $isAvailableToHiring;
    }

    /**
     * @return string
     */
    public function getContactWebsite()
    {
        return $this->contactWebsite;
    }

    /**
     * @param string $contactWebsite
     */
    public function setContactWebsite($contactWebsite)
    {
        $this->contactWebsite = $contactWebsite;
    }

    /**
     * @return string
     */
    public function getContactTwitter()
    {
        return $this->contactTwitter;
    }

    /**
     * @param string $contactTwitter
     */
    public function setContactTwitter($contactTwitter)
    {
        $this->contactTwitter = $contactTwitter;
    }

    /**
     * @return string
     */
    public function getContactLinkedIn()
    {
        return $this->contactLinkedIn;
    }

    /**
     * @param string $contactLinkedIn
     */
    public function setContactLinkedIn($contactLinkedIn)
    {
        $this->contactLinkedIn = $contactLinkedIn;
    }

    /**
     * @return string
     */
    public function getContactCertification()
    {
        return $this->contactCertification;
    }

    /**
     * @param string $contactCertification
     */
    public function setContactCertification($contactCertification)
    {
        $this->contactCertification = $contactCertification;
    }

    /**
     * @return string
     */
    public function getContactGitHub()
    {
        return $this->contactGitHub;
    }

    /**
     * @param string $contactGitHub
     */
    public function setContactGitHub($contactGitHub)
    {
        $this->contactGitHub = $contactGitHub;
    }

    /**
     * @return string
     */
    public function getContactStackOverflow()
    {
        return $this->contactStackOverflow;
    }

    /**
     * @param string $contactStackOverflow
     */
    public function setContactStackOverflow($contactStackOverflow)
    {
        $this->contactStackOverflow = $contactStackOverflow;
    }

    /**
     * @return int
     */
    public function getUpvoteTotal()
    {
        return $this->upvoteTotal;
    }

    /**
     * @param int $upvoteTotal
     */
    public function setUpvoteTotal($upvoteTotal)
    {
        $this->upvoteTotal = $upvoteTotal;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * ================================
     * ============ CUSTOM ============
     * ================================
     */

    public function getFullname() {
        $fullname = sprintf(
            '%s %s',
            $this->getFirstname(),
            $this->getLastname()
        );

        return trim($fullname);
    }

    public static function getGenderCode($gender) {
        if ($gender == self::GENDER_MALE) {
            return 'male';
        } elseif ($gender == self::GENDER_FEMALE) {
            return 'female';
        }

        return false;
    }
}
