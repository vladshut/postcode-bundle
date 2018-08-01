<?php

namespace PostcodeBundle\Services;

use FH\PostcodeAPI\Client;
use PostcodeBundle\Exceptions\InvalidApiResponseException;
use PostcodeBundle\Exceptions\InvalidPostcodeException;
use PostcodeBundle\Model\Address;

/**
 * Class AddressClient
 *
 *
 */
class AddressClient
{
    /** @var Client */
    private $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $postcode
     * @param int $houseNumber
     *
     * @param int|null $from
     * @return Address[]|array
     * @throws InvalidApiResponseException
     * @throws InvalidPostcodeException
     */
    public function getAddresses($postcode, int $houseNumber = null, int $from = null)
    {
        if (0 === preg_match('/^[1-9]{1}[0-9]{3}[\s]{0,1}[a-z]{2}$/i', $postcode)) {
            throw new InvalidPostcodeException('Given postcode incorrect');
        }

        try {
            $data = $this->client->getAddresses($postcode, $houseNumber, $from);

            if (!isset($data->_embedded->addresses)) {
                throw new InvalidApiResponseException('Address cannot be set from API data');
            }

            $addresses = $data->_embedded->addresses;
            $addressesObjects = [];

            foreach ($addresses as $apiData) {
                $addressesObjects[] = $this->getAddressFromApiData($apiData);
            }
        } catch (\Exception $exception) {
            throw new InvalidApiResponseException($exception->getMessage());
        }

        return $addressesObjects;
    }

    /**
     * @param string $id
     *
     * @return Address
     * @throws InvalidApiResponseException
     */
    public function getAddress(string $id)
    {
        try {
            $apiData = $this->client->getAddress($id);
            $address = $this->getAddressFromApiData($apiData);
        } catch (\Exception $exception) {
            throw new InvalidApiResponseException($exception->getMessage());
        }

        return $address;
    }

    /**
     * @param \stdClass $data
     * @return Address
     */
    private function getAddressFromApiData(\stdClass $data)
    {
        $city = $data->city->label ?? null;
        $municipality = $data->municipality->label ?? null;
        $street = $data->street ?? null;
        $province = $data->province->label ?? null;
        $houseNumber = $data->number ?? null;
        $postcode = $data->postcode ?? null;
        $surface = $data->surface ?? null;
        $buildingAge = $data->year ?? null;
        $purpose = $data->purpose ?? null;
        $apiId = $data->id ?? null;
        $letter = $data->letter ?? null;
        $addition = $data->addition ?? null;
        $type = $data->type ?? null;

        $geoLocation = [
            'longitude'  => $data->geo->center->wgs84->coordinates[0] ?? null,
            'latitude' => $data->geo->center->wgs84->coordinates[1] ?? null,
        ];

        $address = new Address(
            $apiId,
            $street,
            $postcode,
            $city,
            $houseNumber,
            $province,
            $municipality,
            $surface,
            $buildingAge,
            $purpose,
            $letter,
            $addition,
            $type
        );

        $address->setGeoLocation($geoLocation);

        return $address;
    }
}
