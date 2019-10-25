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

namespace ApiPlatform\EventsBundle\Event;

use Symfony\Component\EventDispatcher\Event as BaseEvent;
use Symfony\Contracts\EventDispatcher\Event as BaseContractEvent;

if (class_exists(BaseContractEvent::class)) {
    /**
     * @author Alan Poulain <contact@alanpoulain.eu>
     *
     * @psalm-immutable
     */
    abstract class Event extends BaseContractEvent implements EventInterface
    {
        /**
         * @var iterable|object|null
         */
        private $data;
        private $resourceName;
        private $operationName;
        private $context;

        /**
         * @param object|iterable|null $data
         */
        public function __construct($data, ?string $resourceName, string $operationName, array $context = [])
        {
            $this->data = $data;
            $this->resourceName = $resourceName;
            $this->operationName = $operationName;
            $this->context = $context;
        }

        public function getData()
        {
            return $this->data;
        }

        public function withData($data): EventInterface
        {
            $event = clone $this;
            $event->data = $data;

            return $event;
        }

        public function getResourceName(): ?string
        {
            return $this->resourceName;
        }

        public function withResourceName(?string $resourceName): EventInterface
        {
            $event = clone $this;
            $event->resourceName = $resourceName;

            return $event;
        }

        public function getOperationName(): string
        {
            return $this->operationName;
        }

        public function withOperationName(string $operationName): EventInterface
        {
            $event = clone $this;
            $event->operationName = $operationName;

            return $event;
        }

        public function getContext(): array
        {
            return $this->context;
        }

        public function withContext(array $context): EventInterface
        {
            $event = clone $this;
            $event->context = $context;

            return $event;
        }
    }
} else {
    /**
     * @author Alan Poulain <contact@alanpoulain.eu>
     *
     * @psalm-immutable
     */
    abstract class Event extends BaseEvent implements EventInterface
    {
        /**
         * @var iterable|object|null
         */
        private $data;
        private $resourceName;
        private $operationName;
        private $context;

        /**
         * @param object|iterable|null $data
         */
        public function __construct($data, ?string $resourceName, string $operationName, array $context = [])
        {
            $this->data = $data;
            $this->resourceName = $resourceName;
            $this->operationName = $operationName;
            $this->context = $context;
        }

        public function getData()
        {
            return $this->data;
        }

        public function withData($data): EventInterface
        {
            $event = clone $this;
            $event->data = $data;

            return $event;
        }

        public function getResourceName(): ?string
        {
            return $this->resourceName;
        }

        public function withResourceName(?string $resourceName): EventInterface
        {
            $event = clone $this;
            $event->resourceName = $resourceName;

            return $event;
        }

        public function getOperationName(): string
        {
            return $this->operationName;
        }

        public function withOperationName(string $operationName): EventInterface
        {
            $event = clone $this;
            $event->operationName = $operationName;

            return $event;
        }

        public function getContext(): array
        {
            return $this->context;
        }

        public function withContext(array $context): EventInterface
        {
            $event = clone $this;
            $event->context = $context;

            return $event;
        }
    }
}
