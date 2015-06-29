<?php

namespace PHPixie\BundleFramework;

class Components extends \PHPixie\Framework\Components
{
    public function bundles()
    {
        return $this->instance('bundles');
    }
    
    protected function buildBundles()
    {
        return new \PHPixie\Bundles(
            $this->builder->bundles()
        );
    }
}