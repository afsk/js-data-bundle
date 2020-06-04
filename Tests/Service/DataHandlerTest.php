<?php

namespace Zitec\JSDataBundle\Tests\Service;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Zitec\JSDataBundle\DataCollector\DataCollectorInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Zitec\JSDataBundle\Service\DataHandler;

class DataHandlerTest extends TestCase
{
    /**
     * @var MockObject
     */
    protected MockObject $dataCollectorMock;

    /**
     * @var MockObject
     */
    protected MockObject $eventDispatcherMock;

    /**
     * @var DataHandler
     */
    protected DataHandler $dataHandler;

    /**
     * Set up data handler service.
     */
    protected function setUp(): void
    {
        $this->dataCollectorMock = $this->getMockBuilder(DataCollectorInterface::class)->getMock();
        $this->eventDispatcherMock = $this->getMockBuilder(EventDispatcherInterface::class)->getMock();

        $this->dataHandler = new DataHandler($this->dataCollectorMock, $this->eventDispatcherMock);
    }

    /**
     * Test add function.
     */
    public function testAdd()
    {
        $path = 'path';
        $value = 'value';

        $this->dataCollectorMock
            ->expects($this->once())
            ->method('add')
            ->with($path, $value);

        $this->dataHandler->add($path, $value);
    }

    /**
     * Test merge function.
     */
    public function testMerge()
    {
        $array = array('path' => 'value');

        $this->dataCollectorMock
            ->expects($this->once())
            ->method('merge')
            ->with($array);

        $this->dataHandler->merge($array);
    }
}
