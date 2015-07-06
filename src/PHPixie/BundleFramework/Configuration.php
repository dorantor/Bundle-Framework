<?php

namespace PHPixie\BundleFramework;

class Configuration implements \PHPixie\Framework\Configuration
{
    protected $configSlices = array();
    
    public function databaseConfig()
    {
        return $this->configSlice('database');
    }
    
    public function ormConfig()
    {
        return $this->configSlice('orm');
    }
    
    public function routeConfig()
    {
        return $this->configSlice('route');
    }
    
    public function templateConfig()
    {
        return $this->configSlice('template');
    }
    
    public function frameworkConfig()
    {
        return $this->configSlice('framework');
    }
    
    public function ormWrappers()
    {
        $bundles
        return $this->bundles()->ormWrappers();
    }
    
    public function templateFilesystemLocator()
    {
    
    }
    
    public function httpProcessor(){}
    public function routeResolver(){}
    public function filesystemLocator(){}
    
    protected function configSlice($key)
    {
        if(!array_key_exists($key, $this->configSlices)) {
            $config = $this->assets()->config();
            $this->configSlices[$key] = $config->slice($key);
        }
        
        return $this->configSlices[$key];
    }
}