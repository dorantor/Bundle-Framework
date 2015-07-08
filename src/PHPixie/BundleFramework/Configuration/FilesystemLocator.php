<?php

namespace PHPixie\BundleFramework\Configuration;

class FilesystemLocator implements \PHPixie\Filesystem\Locators\Locator
{
    protected $bundleLocators;
    protected $overridesLocator;
    
    public function __construct($bundleLocators, $overridesLocator = null)
    {
        $this->bundleLocators  = $bundleLocators;
        $this->overridesLocator = $overridesLocator;
    }
    
    public function locate($name, $isDirectory = false)
    {
        if($this->overridesLocator !== null) {
            $path = $this->overridesLocator->locate($name, $isDirectory);
            if($path !== null) {
                return $path;
            }
        }
        
        $split = explode(':', $name, 2);
        if(count($split) !== 2 ) {
            return null;
        }
        
        list($locatorName, $name) = $split;
        
        $locator = $this->getLocator($locatorName);
        
        if($locator === null) {
            return null;
        }
        
        return $locator->locate($name, $isDirectory);
    }
    
    protected function getLocator($name)
    {
        return $this->getBundleLocator($name);
    }
    
    protected function getBundleLocator($name)
    {
        return $this->bundleLocators->bundleLocator($name, false);
    }
}