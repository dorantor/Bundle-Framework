<?php

namespace PHPixie\Tests\BundleFramework;

/**
 * @coversDefaultClass \PHPixie\BundleFramework\Processor
 */
abstract class DispatcherTest extends \PHPixie\Tests\Processors\Processor\Dispatcher\RegistryTest
{
    protected function getSliceData()
    {
        return $this->quickMock('\PHPixie\Slice\Data');
    }
    
    abstract protected function dispatcher();
}