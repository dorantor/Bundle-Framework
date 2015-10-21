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
        $configuration = $this->builder->configuration();
        
        return new \PHPixie\Bundles(
            $this->builder->bundles(),
            $configuration->bundlesConfig()
        );
    }
}