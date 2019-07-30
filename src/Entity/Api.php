<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Api
 *
 * @ORM\Table(name="api")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ApiRepository")
 */
class Api
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float")
     */
    private $lat;

    /**
     * @var float
     *
     * @ORM\Column(name="log", type="float")
     */
    private $log;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var float
     *
     * @ORM\Column(name="curtemp", type="float")
     */
    private $curtemp;

    /**
     * @var float
     *
     * @ORM\Column(name="mintemp", type="float")
     */
    private $mintemp;

    /**
     * @var float
     *
     * @ORM\Column(name="maxtemp", type="float")
     */
    private $maxtemp;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="wind", type="string", length=255)
     */
    private $wind;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lat
     *
     * @param float $lat
     *
     * @return Api
     */
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }

    /**
     * Get lat
     *
     * @return float
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set log
     *
     * @param float $log
     *
     * @return Api
     */
    public function setLog($log)
    {
        $this->log = $log;

        return $this;
    }

    /**
     * Get log
     *
     * @return float
     */
    public function getLog()
    {
        return $this->log;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Api
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set time
     *
     * @param \DateTime $time
     *
     * @return Api
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set curtemp
     *
     * @param float $curtemp
     *
     * @return Api
     */
    public function setCurtemp($curtemp)
    {
        $this->curtemp = $curtemp;

        return $this;
    }

    /**
     * Get curtemp
     *
     * @return float
     */
    public function getCurtemp()
    {
        return $this->curtemp;
    }

    /**
     * Set mintemp
     *
     * @param float $mintemp
     *
     * @return Api
     */
    public function setMintemp($mintemp)
    {
        $this->mintemp = $mintemp;

        return $this;
    }

    /**
     * Get mintemp
     *
     * @return float
     */
    public function getMintemp()
    {
        return $this->mintemp;
    }

    /**
     * Set maxtemp
     *
     * @param float $maxtemp
     *
     * @return Api
     */
    public function setMaxtemp($maxtemp)
    {
        $this->maxtemp = $maxtemp;

        return $this;
    }

    /**
     * Get maxtemp
     *
     * @return float
     */
    public function getMaxtemp()
    {
        return $this->maxtemp;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Api
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set wind
     *
     * @param string $wind
     *
     * @return Api
     */
    public function setWind($wind)
    {
        $this->wind = $wind;

        return $this;
    }

    /**
     * Get wind
     *
     * @return string
     */
    public function getWind()
    {
        return $this->wind;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Api
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
