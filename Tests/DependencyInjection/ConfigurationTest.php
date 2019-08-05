<?php

/*
 * This file is part of alanpoulain/ApiPlatformEventsBundle.
 *
 * (c) Alan Poulain <contact@alanpoulain.eu>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace ApiPlatform\EventsBundle\Tests\DependencyInjection;

use ApiPlatform\EventsBundle\DependencyInjection\Configuration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Config\Definition\Processor;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
class ConfigurationTest extends TestCase
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

        $this->assertEquals(['graphql' => ['enabled' => false]], $config);
    }
}
