<?php

namespace PostcodeBundle\Services;

use Exception;
use stdClass;
use VS\PostcodeAPI\Client;
use PostcodeBundle\Exceptions\InvalidApiResponseException;
use PostcodeBundle\Exceptions\InvalidPostcodeException;
use PostcodeBundle\Model\Address;
use VS\PostcodeAPI\Exception\CouldNotParseResponseException;
use VS\PostcodeAPI\Exception\InvalidApiKeyException;
use VS\PostcodeAPI\Exception\InvalidUrlException;
use VS\PostcodeAPI\Exception\ServerErrorException;

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
     * @throws \Http\Client\Exception
     */
    public function getAddresses($postcode, int $houseNumber = null, int $from = null)
    {
        if (0 === preg_match('/^[1-9]{1}[0-9]{3}[\s]{0,1}[a-z]{2}$/i', $postcode)) {
            throw new InvalidPostcodeException('Given postcode incorrect');
        }

        try {
            $data = $this->client->getAddresses($postcode, $houseNumber, $from);
            $addressesObjects = $this->handleAddressesListResponse($data);
        } catch (Exception $exception) {
            throw new InvalidApiResponseException($exception->getMessage());
        }

        return $addressesObjects;
    }

    /**
     * @param string $id
     *
     * @return Address
     * @throws InvalidApiResponseException
     * @throws \Http\Client\Exception
     */
    public function getAddress(string $id)
    {
        try {
            $apiData = $this->client->getAddress($id);
            $address = $this->getAddressFromApiData($apiData);
        } catch (Exception $exception) {
            throw new InvalidApiResponseException($exception->getMessage());
        }

        return $address;
    }

    /**
     * @param stdClass $data
     * @return Address
     */
    private function getAddressFromApiData(stdClass $data)
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

    /**
     * @param $data
     * @param array $addressesObjects
     * @return array
     * @throws InvalidApiResponseException
     * @throws \Http\Client\Exception
     * @throws CouldNotParseResponseException
     * @throws InvalidApiKeyException
     * @throws InvalidUrlException
     * @throws ServerErrorException
     */
    private function handleAddressesListResponse($data, $addressesObjects = [])
    {
        if (!isset($data->_embedded->addresses)) {
            throw new InvalidApiResponseException('Address cannot be set from API data');
        }

        $addresses = $data->_embedded->addresses;

        foreach ($addresses as $apiData) {
            $addressesObjects[] = $this->getAddressFromApiData($apiData);
        }

        if (isset($data->_links->next->href)) {
            $data = $this->client->request($data->_links->next->href);

            $addressesObjects = $this->handleAddressesListResponse($data, $addressesObjects);
        }

        return $addressesObjects;
    }
}
