<?php

namespace PHPixie\BundleFramework\Processor;

class HTTP extends \PHPixie\BundleFramework\Processor
{
    protected function getProcessorNameFor($httpRequest)
    {
        return $httpRequest->attributes()->get('bundle');
    }
}