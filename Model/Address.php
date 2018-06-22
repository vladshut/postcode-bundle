<?php

namespace PostcodeBundle\Model;

/**
 * Class Address
 *
 *
 */
class Address implements \JsonSerializable
{
    /** @var string */
    private $street;

    /** @var string */
    private $postcode;

    /** @var string */
    private $city;

    /** @var string */
    private $number;

    /** @var string */
    private $province;

    /** @var array */
    private $geoLocation;

    /** @var string */
    private $municipality;

    /** @var float in square meters */
    private $surface;

    /** @var int */
    private $buildingAge;

    /** @var string */
    private $purpose;

    /**
     * @param string $street
     * @param string $postcode
     * @param string $city
     * @param string $number
     * @param string $province
     * @param string $municipality
     * @param $surface
     * @param $buildingAge
     * @param $purpose
     */
    public function __construct(
        ?string $street,
        ?string $postcode,
        ?string $city,
        ?string $number,
        ?string $province,
        ?string $municipality,
        ?float $surface,
        ?int $buildingAge,
        ?string $purpose
    ) {
        $this->street   = $street;
        $this->postcode  = $postcode;
        $this->city     = $city;
        $this->number   = $number;
        $this->province = $province;
        $this->municipality = $municipality;
        $this->surface = $surface;
        $this->buildingAge = $buildingAge;
        $this->purpose = $purpose;
    }

    /**
     * @return string
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getPostcode(): ?string
    {
        return $this->postcode;
    }

    /**
     * @return string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @return integer
     */
    public function getNumber(): ?int
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getMunicipality(): ?string
    {
        return $this->municipality;
    }

    /**
     * @return string
     */
    public function getProvince(): ?string
    {
        return $this->province;
    }

    /**
     * @return array
     */
    public function getGeoLocation(): ?array
    {
        return $this->geoLocation;
    }

    /**
     * @param array $geoLocation
     */
    public function setGeoLocation(array $geoLocation)
    {
        $this->geoLocation = $geoLocation;
    }

    /**
     * @return float
     */
    public function getSurface(): ?float
    {
        return $this->surface;
    }

    /**
     * @return int
     */
    public function getBuildingAge(): ?int
    {
        return $this->buildingAge;
    }

    /**
     * @return string
     */
    public function getPurpose(): ?string
    {
        return $this->purpose;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'street' => $this->getStreet(),
            'postcode' => $this->getPostcode(),
            'city' => $this->getCity(),
            'house_number' => $this->getNumber(),
            'province' => $this->getProvince(),
            'municipality' => $this->getMunicipality(),
            'surface'  => $this->getSurface(),
            'building_age'  => $this->getBuildingAge(),
            'purpose'  => $this->getPurpose(),
            'geo_location'  => $this->getGeoLocation(),
        ];
    }
}
