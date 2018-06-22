<?php


namespace PostcodeBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use PostcodeBundle\DependencyInjection\Configuration;
use PostcodeBundle\DependencyInjection\PostcodeExtension;

/**
 * Class ConfigurationTest
 *
 *
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    /**
     * @test
     */
    public function testIt_converts_extension_elements_to_extensions()
    {
        $expectedConfiguration = [
            'api' => [
                'key' => 'secret',
            ],
        ];

        $sources = [__DIR__ . '/Fixtures/config.yml'];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtension()
    {
        return new PostcodeExtension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
