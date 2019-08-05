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

namespace ApiPlatform\EventsBundle\DependencyInjection;

use ApiPlatform\Core\Bridge\Symfony\Bundle\DependencyInjection\Configuration as ApiPlatformConfiguration;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
class ApiPlatformEventsExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container): void
    {
        $apiPlatformConfigs = $container->getExtensionConfig('api_platform');
        $apiPlatformConfig = $this->processConfiguration(new ApiPlatformConfiguration(), $apiPlatformConfigs);

        $config = ['graphql' => ['enabled' => $apiPlatformConfig['graphql']['enabled'] ?? false]];
        $container->prependExtensionConfig('api_platform_events', $config);
    }

    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        if ($config['graphql']['enabled']) {
            $loader->load('graphql.xml');
        }
    }
}
