<?php

namespace PHPixie\BundleFramework;

abstract class Builder extends \PHPixie\Framework\Builder
{
    public function bundles()
    {
        return $this->instance('bundles');
    }
    
    protected function buildComponents()
    {
        return new Components($this);
    }
    

    
    abstract protected function buildBundles();
}