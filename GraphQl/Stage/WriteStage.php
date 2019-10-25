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

namespace ApiPlatform\EventsBundle\GraphQl\Stage;

use ApiPlatform\Core\GraphQl\Resolver\Stage\WriteStageInterface;
use ApiPlatform\EventsBundle\Event\PostWriteEvent;
use ApiPlatform\EventsBundle\Event\PreWriteEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class WriteStage implements WriteStageInterface
{
    private $writeStage;
    private $eventDispatcher;

    public function __construct(WriteStageInterface $writeStage, EventDispatcherInterface $eventDispatcher)
    {
        $this->writeStage = $writeStage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * {@inheritdoc}
     */
    public function __invoke($data, string $resourceClass, string $operationName, array $context)
    {
        $this->eventDispatcher->dispatch(new PreWriteEvent($data, $resourceClass, $operationName, $context));

        $writtenObject = ($this->writeStage)($data, $resourceClass, $operationName, $context);

        $this->eventDispatcher->dispatch(new PostWriteEvent($writtenObject, $resourceClass, $operationName, $context));

        return $writtenObject;
    }
}
