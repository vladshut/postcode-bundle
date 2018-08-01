<?php

namespace PostcodeBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use PostcodeBundle\Model\Address;

/**
 * Class AddressTest
 *
 *
 */
class AddressTest extends TestCase
{
    public function testAddress()
    {
        $addressValues = [
            'apiId' => '8672364782364',
            'street' => 'Test Street',
            'postcode' => '1010AB',
            'city' => 'Haarlem',
            'house_number' => 666,
            'province' => 'Noord-Holland',
            'municipality' => 'Haarlem',
            'surface' => 60.0,
            'building_age' => 1994,
            'purpose' => 'living',
            'geo_location' => ['lat' => 42.3243, 'long' => 32.3424],
            'letter' => 'A',
            'addition' => null,
            'type' => 'Verblijfsobject',
        ];

        $address = new Address(
            $addressValues['apiId'],
            $addressValues['street'],
            $addressValues['postcode'],
            $addressValues['city'],
            $addressValues['house_number'],
            $addressValues['province'],
            $addressValues['municipality'],
            $addressValues['surface'],
            $addressValues['building_age'],
            $addressValues['purpose'],
            $addressValues['letter'],
            $addressValues['addition'],
            $addressValues['type']
        );
        $address->setGeoLocation($addressValues['geo_location']);

        $this->assertSame($address->getApiId(), $addressValues['apiId']);
        $this->assertSame($address->getStreet(), $addressValues['street']);
        $this->assertSame($address->getPostcode(), $addressValues['postcode']);
        $this->assertSame($address->getCity(), $addressValues['city']);
        $this->assertSame($address->getNumber(), $addressValues['house_number']);
        $this->assertSame($address->getProvince(), $addressValues['province']);
        $this->assertSame($address->getMunicipality(), $addressValues['municipality']);
        $this->assertSame($address->getSurface(), $addressValues['surface']);
        $this->assertSame($address->getBuildingAge(), $addressValues['building_age']);
        $this->assertSame($address->getPurpose(), $addressValues['purpose']);
        $this->assertSame($address->getGeoLocation(), $addressValues['geo_location']);
        $this->assertSame($address->getLetter(), $addressValues['letter']);
        $this->assertSame($address->getAddition(), $addressValues['addition']);
        $this->assertSame($address->getType(), $addressValues['type']);

        $this->assertSame($addressValues, $address->jsonSerialize());
    }
}
