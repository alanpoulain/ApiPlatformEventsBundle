<?php

/*
 * This file is part of alanpoulain/ApiPlatformEventsBundle.
 *
 * (c) Alan Poulain <contact@alanpoulain.eu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\EventsBundle\Tests\DependencyInjection;

use ApiPlatform\EventsBundle\DependencyInjection\ApiPlatformEventsExtension;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @covers \ApiPlatform\EventsBundle\DependencyInjection\ApiPlatformEventsExtension
 *
 * @internal
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class ApiPlatformEventsExtensionTest extends TestCase
{
    private $extension;
    private $containerBuilderProphecy;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->extension = new ApiPlatformEventsExtension();
        $this->containerBuilderProphecy = $this->prophesize(ContainerBuilder::class);

        $this->containerBuilderProphecy->hasExtension('http://symfony.com/schema/dic/services')->willReturn();
        if (method_exists(ContainerBuilder::class, 'removeBindings')) {
            $this->containerBuilderProphecy->removeBindings(Argument::type('string'))->will(function () {});
        }
        $this->containerBuilderProphecy->fileExists(Argument::type('string'))->will(function ($args) {
            return file_exists($args[0]);
        });
    }

    public function testLoadGraphQlEnabled(): void
    {
        $definitions = [
            'api_platform.graphql.resolver.stage.deserialize.event',
            'api_platform.graphql.resolver.stage.read.event',
            'api_platform.graphql.resolver.stage.serialize.event',
            'api_platform.graphql.resolver.stage.validate.event',
            'api_platform.graphql.resolver.stage.write.event',
        ];

        foreach ($definitions as $definition) {
            $this->containerBuilderProphecy->setDefinition($definition, Argument::type(Definition::class))->shouldBeCalled();
        }

        $this->extension->load([['graphql' => ['enabled' => true]]], $this->containerBuilderProphecy->reveal());
    }

    public function testLoadGraphQlDisabled(): void
    {
        $definitions = [
            'api_platform.graphql.resolver.stage.deserialize.event',
            'api_platform.graphql.resolver.stage.read.event',
            'api_platform.graphql.resolver.stage.serialize.event',
            'api_platform.graphql.resolver.stage.validate.event',
            'api_platform.graphql.resolver.stage.write.event',
        ];

        foreach ($definitions as $definition) {
            $this->containerBuilderProphecy->setDefinition($definition, Argument::type(Definition::class))->shouldNotBeCalled();
        }

        $this->extension->load([], $this->containerBuilderProphecy->reveal());
    }
}
