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

use ApiPlatform\Core\GraphQl\Resolver\Stage\ValidateStageInterface;
use ApiPlatform\EventsBundle\Event\PostValidateEvent;
use ApiPlatform\EventsBundle\Event\PreValidateEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class ValidateStage implements ValidateStageInterface
{
    private $validateStage;
    private $eventDispatcher;

    public function __construct(ValidateStageInterface $validateStage, EventDispatcherInterface $eventDispatcher)
    {
        $this->validateStage = $validateStage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function apply($object, string $resourceClass, string $operationName, array $context): void
    {
        $this->eventDispatcher->dispatch(new PreValidateEvent($object, $resourceClass, $operationName, $context));

        $this->validateStage->apply($object, $resourceClass, $operationName, $context);

        $this->eventDispatcher->dispatch(new PostValidateEvent($object, $resourceClass, $operationName, $context));
    }
}
