<?php

namespace PHPixie\BundleFramework\Configuration\FilesystemLocator;

class Template extends \PHPixie\BundleFramework\Configuration\FilesystemLocator
{
    protected $assets;
    
    public function __construct($bundleLocators, $assets, $overrideLocator = null)
    {
        $this->assets = $assets;
        parent::__construct($bundleLocators, $overrideLocator);
    }
    
    protected function getLocator($name)
    {
        if($name === 'framework')
        {
            return $this->assets->frameworkTemplateLocator();
        }
        
        return $this->getBundleLocator($name);
    }
}