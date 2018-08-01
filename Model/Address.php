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
    private $apiId;

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

    /** @var string */
    private $letter;

    /** @var string */
    private $addition;

    /**
     * @param string $apiId
     * @param string $street
     * @param string $postcode
     * @param string $city
     * @param string $number
     * @param string $province
     * @param string $municipality
     * @param float|null $surface
     * @param int|null $buildingAge
     * @param null|string $purpose
     * @param null|string $letter
     * @param null|string $addition
     */
    public function __construct(
        string $apiId,
        ?string $street,
        ?string $postcode,
        ?string $city,
        ?string $number,
        ?string $province,
        ?string $municipality,
        ?float $surface,
        ?int $buildingAge,
        ?string $purpose,
        ?string $letter,
        ?string $addition
    )
    {
        $this->apiId = $apiId;
        $this->street = $street;
        $this->postcode = $postcode;
        $this->city = $city;
        $this->number = $number;
        $this->province = $province;
        $this->municipality = $municipality;
        $this->surface = $surface;
        $this->buildingAge = $buildingAge;
        $this->purpose = $purpose;
        $this->letter = $letter;
        $this->addition = $addition;
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
     * @return string
     */
    public function getApiId(): string
    {
        return $this->apiId;
    }

    /**
     * @return string
     */
    public function getLetter(): ?string
    {
        return $this->letter;
    }

    /**
     * @return string
     */
    public function getAddition(): ?string
    {
        return $this->addition;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'apiId' => $this->getApiId(),
            'street' => $this->getStreet(),
            'postcode' => $this->getPostcode(),
            'city' => $this->getCity(),
            'house_number' => $this->getNumber(),
            'province' => $this->getProvince(),
            'municipality' => $this->getMunicipality(),
            'surface' => $this->getSurface(),
            'building_age' => $this->getBuildingAge(),
            'purpose' => $this->getPurpose(),
            'geo_location' => $this->getGeoLocation(),
            'letter' => $this->getLetter(),
            'addition' => $this->getAddition(),
        ];
    }
}
