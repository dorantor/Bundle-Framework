<?php

namespace PHPixie\Bundles;

class Configuration implements \PHPixie\Framework\Configuration
{
    public function filesystemRoot()
    {
        return $this->instance('filesystemRoot');
    }
    
    public function httpProcessor()
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
    
    protected function buildFilesystemRoot()
    {
        $rootDir = $this->getRootDirectory();
        return $this->components->filesystem->root($rootDir);
    }
    
    protected function getRootDirectory()
    {
        return realpath(__DIR__.'/../../../');
    }
    
    protected function bundles()
    {
        return $this->builder->components()->bundles();
    }
    
}