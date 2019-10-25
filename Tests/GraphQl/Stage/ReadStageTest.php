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

use ApiPlatform\Core\GraphQl\Resolver\Stage\ReadStageInterface;
use ApiPlatform\EventsBundle\Event\PostReadEvent;
use ApiPlatform\EventsBundle\Event\PreReadEvent;
use ApiPlatform\EventsBundle\GraphQl\Stage\ReadStage;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @covers \ApiPlatform\EventsBundle\GraphQl\Stage\ReadStage
 *
 * @internal
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class ReadStageTest extends TestCase
{
    private $readStageInner;
    private $eventDispatcher;
    private $readStage;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->readStageInner = $this->prophesize(ReadStageInterface::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->readStage = new ReadStage($this->readStageInner->reveal(), $this->eventDispatcher->reveal());
    }

    public function testInvoke(): void
    {
        $resourceClass = 'resourceClass';
        $rootClass = 'rootClass';
        $operationName = 'operationName';
        $context = [];
        $expectedReadObject = new \stdClass();

        $this->eventDispatcher->dispatch(Argument::type(PreReadEvent::class))->shouldBeCalled();
        $this->eventDispatcher->dispatch(Argument::type(PostReadEvent::class))->shouldBeCalled();
        $this->readStageInner->__invoke($resourceClass, $rootClass, $operationName, $context)->shouldBeCalled()->willReturn($expectedReadObject);

        $readObject = ($this->readStage)($resourceClass, $rootClass, $operationName, $context);

        static::assertSame($expectedReadObject, $readObject);
    }
}
