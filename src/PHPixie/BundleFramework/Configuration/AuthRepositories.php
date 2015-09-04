<?php

namespace PHPixie\BundleFramework\Configuration;

class AuthRepositories implements \PHPixie\Auth\Repositories\Registry
{
    protected $bundleRepositories;
    
    public function __construct($bundleRepositories)
    {
        $this->bundleRepositories = $bundleRepositories;
    }
    
    public function repository($name)
    {
        $split = explode('.', $name, 2);
        list($bundleName, $name) = $split;
        
        $locator = $this->getLocator($locatorName);
        
        if($locator === null) {
            return null;
        }
        
        return $locator->locate($name, $isDirectory)
    }
}