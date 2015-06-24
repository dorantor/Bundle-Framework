<?php

namespace PHPixie\BundleFramework;

class Builder extends \PHPixie\Framework\Builder
{
    protected function buildComponents()
    {
        return new Components($this);
    }
    
    abstract protected function buildBundles();
}