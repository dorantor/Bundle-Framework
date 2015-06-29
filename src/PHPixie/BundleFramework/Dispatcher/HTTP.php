<?php

namespace PHPixie\BundleFramework\Dispatcher;

class HTTP extends \PHPixie\BundleFramework\Dispatcher
{
    protected function getProcessorNameFor($httpRequest)
    {
        return $httpRequest->attributes()->get('bundle');
    }
}