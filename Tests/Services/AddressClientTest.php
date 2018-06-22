<?php


namespace PostcodeBundle\Tests\Services;

use PHPUnit\Framework\TestCase;
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

    /** @var \PHPUnit_Framework_MockObject_MockObject|\FH\PostcodeAPI\Client */
    private $apiClient;

    /** @var \PHPUnit_Framework_MockObject_MockObject|ResponseInterface */
    private $response;

    /** @var \PHPUnit_Framework_MockObject_MockObject|StreamInterface */
    private $stream;

    public function setUp()
    {
        $this->apiClient = $this->createApiClientMock();
        $this->stream   = $this->createStreamInterfaceMock();

        $this->addressClient = new AddressClient($this->apiClient);
    }

    /**
     * @throws \PostcodeBundle\Exceptions\InvalidApiResponseException
     * @throws \PostcodeBundle\Exceptions\InvalidPostcodeException
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
     * @expectedException \PostcodeBundle\Exceptions\InvalidPostcodeException
     * @throws \PostcodeBundle\Exceptions\InvalidApiResponseException
     */
    public function testGetAddressWithInvalidPostcode()
    {
        $this->apiClient->expects($this->never())
            ->method('getAddresses');

        $this->addressClient->getAddresses('*@NXNI@', 18);
    }

    /**
     * @expectedException \PostcodeBundle\Exceptions\InvalidApiResponseException
     * @throws \PostcodeBundle\Exceptions\InvalidPostcodeException
     */
    public function testGetAddressWithInvalidResponse()
    {
        $this->apiClient->expects($this->once())
            ->method('getAddresses')
            ->willReturn($this->response);

        $this->addressClient->getAddresses('1010AB', 18);
    }

    /**
     * @expectedException \PostcodeBundle\Exceptions\InvalidApiResponseException
     * @throws \PostcodeBundle\Exceptions\InvalidPostcodeException
     */
    public function testGetAddressWithInvalidJsonResponse()
    {
        $this->apiClient->expects($this->once())
            ->method('getAddresses')
            ->willReturn(json_decode(file_get_contents(__DIR__ . '/invalid.json')));

        $this->addressClient->getAddresses('1010AB', 18);
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|\FH\PostcodeAPI\Client
     */
    private function createApiClientMock()
    {
        return $this->createMock('\FH\PostcodeAPI\Client');
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|StreamInterface
     */
    private function createStreamInterfaceMock()
    {
        return $this->createMock('Psr\Http\Message\StreamInterface');
    }
}
