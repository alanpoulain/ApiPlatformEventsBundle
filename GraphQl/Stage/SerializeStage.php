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

use ApiPlatform\Core\GraphQl\Resolver\Stage\SerializeStageInterface;
use ApiPlatform\EventsBundle\Event\PostSerializeEvent;
use ApiPlatform\EventsBundle\Event\PreSerializeEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class SerializeStage implements SerializeStageInterface
{
    private $serializeStage;
    private $eventDispatcher;

    public function __construct(SerializeStageInterface $serializeStage, EventDispatcherInterface $eventDispatcher)
    {
        $this->serializeStage = $serializeStage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function apply($itemOrCollection, string $resourceClass, string $operationName, array $context): ?array
    {
        $this->eventDispatcher->dispatch(new PreSerializeEvent($itemOrCollection, $resourceClass, $operationName, $context));

        $serializedData = $this->serializeStage->apply($itemOrCollection, $resourceClass, $operationName, $context);

        $this->eventDispatcher->dispatch(new PostSerializeEvent($serializedData, $resourceClass, $operationName, $context));

        return $serializedData;
    }
}
