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

namespace ApiPlatform\EventsBundle\Tests\GraphQl\Stage;

use ApiPlatform\Core\GraphQl\Resolver\Stage\ValidateStageInterface;
use ApiPlatform\EventsBundle\Event\PostValidateEvent;
use ApiPlatform\EventsBundle\Event\PreValidateEvent;
use ApiPlatform\EventsBundle\GraphQl\Stage\ValidateStage;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @covers \ApiPlatform\EventsBundle\GraphQl\Stage\ValidateStage
 *
 * @internal
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class ValidateStageTest extends TestCase
{
    private $validateStageInner;
    private $eventDispatcher;
    private $validateStage;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->validateStageInner = $this->prophesize(ValidateStageInterface::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->validateStage = new ValidateStage($this->validateStageInner->reveal(), $this->eventDispatcher->reveal());
    }

    public function testInvoke(): void
    {
        $object = new \stdClass();
        $resourceClass = 'resourceClass';
        $operationName = 'operationName';
        $context = [];

        $this->eventDispatcher->dispatch(Argument::type(PreValidateEvent::class))->shouldBeCalled();
        $this->eventDispatcher->dispatch(Argument::type(PostValidateEvent::class))->shouldBeCalled();
        $this->validateStageInner->__invoke($object, $resourceClass, $operationName, $context)->shouldBeCalled();

        ($this->validateStage)($object, $resourceClass, $operationName, $context);
    }
}
