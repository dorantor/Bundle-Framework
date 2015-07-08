<?php

namespace PHPixie\BundleFramework\Configuration\FilesystemLocator;

class Template extends \PHPixie\BundleFramework\Configuration\FilesystemLocator
{
    protected $assets;
    
    public function __construct($bundleLocators, $assets, $overridesLocator = null)
    {
        $this->assets = $assets;
        parent::__construct($bundleLocators, $overridesLocator);
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