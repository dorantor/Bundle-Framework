<?php

namespace PHPixie\Tests\BundleFramework\Processor;

/**
 * @coversDefaultClass \PHPixie\BundleFramework\Processor\HTTP
 */
class HTTPTest extends \PHPixie\Tests\BundleFramework\ProcessorTest
{
    /**
     * @covers ::process
     * @covers ::<protected>
     */
    public function testProcess()
    {
        $dispatcher = $this->dispatcher();
        
        $request = $this->getValue();
        
        $attributes = $this->getSliceData();
        $this->method($attributes, 'get', 'pixie', array('bundle'), 0);
        
        $this->method($request, 'attributes', $attributes, array(), 0);
        
        $processor = $this->getProcessor();
        $this->method($this->registry, 'get', $processor, array('pixie'), 0);
        
        $this->method($processor, 'process', 'trixie', array($request), 0);
        
        $this->assertSame('trixie', $dispatcher->process($request));
    }
    
    protected function getValue()
    {
        return $this->quickMock('\PHPixie\HTTP\Request');
    }
    
    protected function dispatcher()
    {
        return new \PHPixie\BundleFramework\Processor\HTTP($this->registry);
    }
    
    protected function dispatcherMock($methods = array())
    {
        return $this->getMock(
            '\PHPixie\BundleFramework\Processor\HTTP',
            $methods,
            array($this->registry)
        );
    }
}