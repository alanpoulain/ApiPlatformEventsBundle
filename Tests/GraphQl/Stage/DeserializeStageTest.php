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

use ApiPlatform\Core\GraphQl\Resolver\Stage\DeserializeStageInterface;
use ApiPlatform\EventsBundle\Event\PostDeserializeEvent;
use ApiPlatform\EventsBundle\Event\PreDeserializeEvent;
use ApiPlatform\EventsBundle\GraphQl\Stage\DeserializeStage;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @covers \ApiPlatform\EventsBundle\GraphQl\Stage\DeserializeStage
 *
 * @internal
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class DeserializeStageTest extends TestCase
{
    private $deserializeStageInner;
    private $eventDispatcher;
    private $deserializeStage;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->deserializeStageInner = $this->prophesize(DeserializeStageInterface::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->deserializeStage = new DeserializeStage($this->deserializeStageInner->reveal(), $this->eventDispatcher->reveal());
    }

    public function testInvoke(): void
    {
        $objectToPopulate = new \stdClass();
        $resourceClass = 'resourceClass';
        $operationName = 'operationName';
        $context = [];
        $expectedDeserializedObject = new \stdClass();

        $this->eventDispatcher->dispatch(Argument::type(PreDeserializeEvent::class))->shouldBeCalled();
        $this->eventDispatcher->dispatch(Argument::type(PostDeserializeEvent::class))->shouldBeCalled();
        $this->deserializeStageInner->__invoke($objectToPopulate, $resourceClass, $operationName, $context)->shouldBeCalled()->willReturn($expectedDeserializedObject);

        $deserializedObject = ($this->deserializeStage)($objectToPopulate, $resourceClass, $operationName, $context);

        static::assertSame($expectedDeserializedObject, $deserializedObject);
    }
}
