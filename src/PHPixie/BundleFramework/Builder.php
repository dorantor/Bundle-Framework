<?php

namespace PHPixie\BundleFramework;

abstract class Builder extends \PHPixie\Framework\Builder
{
    public function configuration()
    {
        return $this->instance('configuration');
    }
    
    public function bundles()
    {
        return $this->instance('bundles');
    }
    
    protected function buildComponents()
    {
        return new Components($this);
    }
    
    protected function buildAssets()
    {
        return new Assets(
            $this->components(),
            $this->getRootDirectory()
        );
    }
    
    protected function buildConfiguration()
    {
        return new Configuration($this);
    }
    
    abstract protected function buildBundles();
    abstract protected function getRootDirectory();
}