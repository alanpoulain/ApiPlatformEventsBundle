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

use ApiPlatform\Core\GraphQl\Resolver\Stage\SerializeStageInterface;
use ApiPlatform\EventsBundle\Event\PostSerializeEvent;
use ApiPlatform\EventsBundle\Event\PreSerializeEvent;
use ApiPlatform\EventsBundle\GraphQl\Stage\SerializeStage;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @covers \ApiPlatform\EventsBundle\GraphQl\Stage\SerializeStage
 *
 * @internal
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class SerializeStageTest extends TestCase
{
    private $serializeStageInner;
    private $eventDispatcher;
    private $serializeStage;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->serializeStageInner = $this->prophesize(SerializeStageInterface::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->serializeStage = new SerializeStage($this->serializeStageInner->reveal(), $this->eventDispatcher->reveal());
    }

    public function testInvoke(): void
    {
        $itemOrCollection = new \stdClass();
        $resourceClass = 'resourceClass';
        $operationName = 'operationName';
        $context = [];
        $expectedSerializedData = ['serialized_data'];

        $this->eventDispatcher->dispatch(Argument::type(PreSerializeEvent::class))->shouldBeCalled();
        $this->eventDispatcher->dispatch(Argument::type(PostSerializeEvent::class))->shouldBeCalled();
        $this->serializeStageInner->__invoke($itemOrCollection, $resourceClass, $operationName, $context)->shouldBeCalled()->willReturn($expectedSerializedData);

        $serializedData = ($this->serializeStage)($itemOrCollection, $resourceClass, $operationName, $context);

        static::assertSame($expectedSerializedData, $serializedData);
    }
}
