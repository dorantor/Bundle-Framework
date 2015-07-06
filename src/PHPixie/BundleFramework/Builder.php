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
    
    public function assets(){}

    
    abstract protected function buildBundles();
}