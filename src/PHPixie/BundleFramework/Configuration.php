<?php

namespace PHPixie\Bundles;

class Configuration
{
    
    public function httpDispatcher()
    {
        return $this->bundles()->httpDispatcher();
    }
    
    public function ormWrappers()
    {
        return $this->bundles()->ormWrappers();
    }
    
    protected function buildRouteResolver()
    {
        $components = $this->builder->components();
        
        return $components->route()->buildResolver(
            $this->configData()->slice('route'),
            $this->bundles()->routeResolver()
        );   
    }
    
    protected function buildFilesystemLocator()
    {
        $components = $this->builder->components();
        
        return $components->filesystem()->buildLocator(
            $this->configData()->slice('filesystem'),
            $this->bundles()->filesystemLocators()
        );
    }
    
    protected function buildConfigData()
    {
        $config = $this->builder->components->config();
        $directory = $this->filesystemRoot()->path('assets');
        return $config->directory($directory, 'config');
    }
    
    protected function bundles()
    {
        return $this->builder->components()->bundles();
    }
    
}