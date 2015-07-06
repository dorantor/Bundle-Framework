<?php

namespace PHPixie\BundleFramework;

abstract class Bundles implements \PHPixie\Bundles\Registry
{
    protected $builder;
    protected $bundles;
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function bundles()
    {
        $this->requireBundles();
        return $this->bundles;
    }
    
    public function get($name, $isRequired = true)
    {
        $this->requireBundles();
        
        if(array_key_exists($name, $this->bundles)) {
            return $this->bundles[$name];
        }
        
        if(!$isRequired) {
            return null;
        }
        
        throw new \PHPixie\BundleFramework\Exception("Bundle '$name' does not exist");
    }    
    
    protected function requireBundles()
    {
        if($this->bundles !== null) {
            return;
        }
        
        $bundles = array();
        foreach($this->buildBundles() as $bundle) {
            $bundles[$bundle->name()] = $bundle;
        }
        
        $this->bundles = $bundles;
    }
    
    abstract protected function buildBundles();
}