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

namespace ApiPlatform\EventsBundle\GraphQl\Stage;

use ApiPlatform\Core\GraphQl\Resolver\Stage\ReadStageInterface;
use ApiPlatform\EventsBundle\Event\PostReadEvent;
use ApiPlatform\EventsBundle\Event\PreReadEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class ReadStage implements ReadStageInterface
{
    private $readStage;
    private $eventDispatcher;

    public function __construct(ReadStageInterface $readStage, EventDispatcherInterface $eventDispatcher)
    {
        $this->readStage = $readStage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function apply(?string $resourceClass, ?string $rootClass, string $operationName, array $context)
    {
        $this->eventDispatcher->dispatch(new PreReadEvent(null, $resourceClass, $operationName, $context));

        $readObject = $this->readStage->apply($resourceClass, $rootClass, $operationName, $context);

        $this->eventDispatcher->dispatch(new PostReadEvent($readObject, $resourceClass, $operationName, $context));

        return $readObject;
    }
}
