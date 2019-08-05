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

use ApiPlatform\Core\GraphQl\Resolver\Stage\DeserializeStageInterface;
use ApiPlatform\EventsBundle\Event\PostDeserializeEvent;
use ApiPlatform\EventsBundle\Event\PreDeserializeEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class DeserializeStage implements DeserializeStageInterface
{
    private $deserializeStage;
    private $eventDispatcher;

    public function __construct(DeserializeStageInterface $deserializeStage, EventDispatcherInterface $eventDispatcher)
    {
        $this->deserializeStage = $deserializeStage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function apply($objectToPopulate, string $resourceClass, string $operationName, array $context)
    {
        $this->eventDispatcher->dispatch(new PreDeserializeEvent($objectToPopulate, $resourceClass, $operationName, $context));

        $deserializedObject = $this->deserializeStage->apply($objectToPopulate, $resourceClass, $operationName, $context);

        $this->eventDispatcher->dispatch(new PostDeserializeEvent($deserializedObject, $resourceClass, $operationName, $context));

        return $deserializedObject;
    }
}
