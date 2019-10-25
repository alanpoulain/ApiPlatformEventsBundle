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

use ApiPlatform\Core\GraphQl\Resolver\Stage\WriteStageInterface;
use ApiPlatform\EventsBundle\Event\PostWriteEvent;
use ApiPlatform\EventsBundle\Event\PreWriteEvent;
use ApiPlatform\EventsBundle\GraphQl\Stage\WriteStage;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * @covers \ApiPlatform\EventsBundle\GraphQl\Stage\WriteStage
 *
 * @internal
 *
 * @author Alan Poulain <contact@alanpoulain.eu>
 */
final class WriteStageTest extends TestCase
{
    private $writeStageInner;
    private $eventDispatcher;
    private $writeStage;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $this->writeStageInner = $this->prophesize(WriteStageInterface::class);
        $this->eventDispatcher = $this->prophesize(EventDispatcherInterface::class);
        $this->writeStage = new WriteStage($this->writeStageInner->reveal(), $this->eventDispatcher->reveal());
    }

    public function testInvoke(): void
    {
        $data = new \stdClass();
        $resourceClass = 'resourceClass';
        $operationName = 'operationName';
        $context = [];
        $expectedWrittenObject = new \stdClass();

        $this->eventDispatcher->dispatch(Argument::type(PreWriteEvent::class))->shouldBeCalled();
        $this->eventDispatcher->dispatch(Argument::type(PostWriteEvent::class))->shouldBeCalled();
        $this->writeStageInner->__invoke($data, $resourceClass, $operationName, $context)->shouldBeCalled()->willReturn($expectedWrittenObject);

        $writtenObject = ($this->writeStage)($data, $resourceClass, $operationName, $context);

        static::assertSame($expectedWrittenObject, $writtenObject);
    }
}
