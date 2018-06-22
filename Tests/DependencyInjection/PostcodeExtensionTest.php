<?php

namespace PostcodeBundle\Tests\DependencyInjection;

use PostcodeBundle\DependencyInjection\PostcodeExtension;
use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;

/**
 * Class AppPostcodeExtensionTest
 *
 *
 */
class AppPostcodeExtensionTest extends AbstractExtensionTestCase
{
    public function testAfterLoadingTheCorrectParameterHasBeenSet()
    {
        $this->load(['api' => ['key' => 'secret']]);

        $this->assertContainerBuilderHasParameter('postcode_api_key', 'secret');
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new PostcodeExtension(),
        ];
    }
}
