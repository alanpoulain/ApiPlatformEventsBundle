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

namespace ApiPlatform\EventsBundle\Event;

/**
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
interface EventInterface
{
    public function getData();

    public function withData($data): self;

    public function getResourceName(): ?string;

    public function withResourceName(?string $resourceName): self;

    public function getOperationName(): string;

    public function withOperationName(string $operationName): self;

    public function getContext(): array;

    public function withContext(array $context): self;
}
