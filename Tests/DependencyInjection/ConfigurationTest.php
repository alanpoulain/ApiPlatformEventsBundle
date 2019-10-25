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

use ApiPlatform\EventsBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

/**
 * @covers \ApiPlatform\EventsBundle\DependencyInjection\Configuration
 *
 * @internal
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class ConfigurationTest extends TestCase
{
    private $configuration;
    private $processor;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->configuration = new Configuration();
        $this->processor = new Processor();
    }

    public function testDefaultConfig(): void
    {
        $config = $this->processor->processConfiguration($this->configuration, []);

        static::assertSame(['graphql' => ['enabled' => false]], $config);
    }
}
