<?php


namespace PostcodeBundle\Tests\Services;

use Http\Client\Exception;
use VS\PostcodeAPI\Client;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use PostcodeBundle\Exceptions\InvalidApiResponseException;
use PostcodeBundle\Exceptions\InvalidPostcodeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use PostcodeBundle\Services\AddressClient;

/**
 * Class AddressClientTest
 *
 *
 */
class AddressClientTest extends TestCase
{
    /** @var AddressClient */
    private $addressClient;

    /** @var PHPUnit_Framework_MockObject_MockObject|Client */
    private $apiClient;

    /** @var PHPUnit_Framework_MockObject_MockObject|ResponseInterface */
    private $response;

    /** @var PHPUnit_Framework_MockObject_MockObject|StreamInterface */
    private $stream;

    public function setUp()
    {
        $this->apiClient = $this->createApiClientMock();
        $this->stream   = $this->createStreamInterfaceMock();

        $this->addressClient = new AddressClient($this->apiClient);
    }

    /**
     * @throws InvalidApiResponseException
     * @throws InvalidPostcodeException
     * @throws Exception
     */
    public function testGetAddresses()
    {
        $this->apiClient->expects($this->once())
            ->method('getAddresses')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/response.json')));

        $addresses = $this->addressClient->getAddresses('1010AB', 18);

        $this->assertCount(1, $addresses);
        $this->assertInstanceOf("\PostcodeBundle\Model\Address", reset($addresses));
    }

    /**
     * @expectedException PostcodeBundle\Exceptions\InvalidPostcodeException
     * @throws Exception
     * @throws InvalidApiResponseException
     * @throws InvalidPostcodeException
     */
    public function testGetAddressWithInvalidPostcode()
    {
        $this->apiClient->expects($this->never())
            ->method('getAddresses');

        $this->addressClient->getAddresses('*@NXNI@', 18);
    }

    /**
     * @expectedException PostcodeBundle\Exceptions\InvalidApiResponseException
     * @throws Exception
     * @throws InvalidApiResponseException
     * @throws InvalidPostcodeException
     */
    public function testGetAddressWithInvalidResponse()
    {
        $this->apiClient->expects($this->once())
            ->method('getAddresses')
            ->willReturn($this->response);

        $this->addressClient->getAddresses('1010AB', 18);
    }

    /**
     * @expectedException PostcodeBundle\Exceptions\InvalidApiResponseException
     * @throws Exception
     * @throws InvalidApiResponseException
     * @throws InvalidPostcodeException
     */
    public function testGetAddressWithInvalidJsonResponse()
    {
        $this->apiClient->expects($this->once())
            ->method('getAddresses')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/invalid.json')));

        $this->addressClient->getAddresses('1010AB', 18);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|Client
     */
    private function createApiClientMock()
    {
        return $this->createMock(Client::class);
    }

    /**
     * @return PHPUnit_Framework_MockObject_MockObject|StreamInterface
     */
    private function createStreamInterfaceMock()
    {
        return $this->createMock('Psr\Http\Message\StreamInterface');
    }
}
