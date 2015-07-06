<?php

namespace PHPixie\BundleFramework;

class Configuration implements \PHPixie\Framework\Configuration
{
    protected $builder;
    protected $instances = array();
    
    public function __construct($builder)
    {
        $this->builder = $builder;
    }
    
    public function databaseConfig()
    {
        return $this->instance('databaseConfig');
    }
    
    public function frameworkConfig()
    {
        return $this->instance('frameworkConfig');
    }
    
    public function routeTranslatorConfig()
    {
        return $this->instance('routeTranslatorConfig');
    }
    
    public function templateConfig()
    {
        return $this->instance('templateConfig');
    }
    
    public function filesystemRoot()
    {
        return $this->builder->assets()->root();
    }
    
    public function orm()
    {
        return $this->instance('orm');
    }
    
    public function ormConfig()
    {
        return $this->orm()->configData();
    }
    
    public function ormWrappers()
    {
        return $this->orm()->wrappers();
    }
    
    public function httpProcessor()
    {
        return $this->instance('httpProcessor');
    }
    
    public function routeResolver()
    {
        return $this->instance('routeResolver');
    }
    
    public function templateLocator()
    {
        return $this->instance('templateLocator');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildDatabaseConfig()
    {
        return $this->configStorage()->slice('database');
    }
    
    protected function buildFrameworkConfig()
    {
        return $this->configStorage()->slice('framework');
    }
    
    protected function buildRouteTranslatorConfig()
    {
        return $this->configStorage()->slice('route');
    }
    
    protected function buildTemplateConfig()
    {
        return $this->configStorage()->slice('template');
    }
    
    protected function buildOrm()
    {
        $components = $this->builder->components();
        
        return new Configuration\ORM(
            $components->slice(),
            $components->bundles()->orm()
        );
    }
    
    protected function buildHttpProcessor()
    {
        $components = $this->builder->components();
        
        return $components->httpProcessors()->attributeRegistryDispatcher(
            $components->bundles()->httpProcessors(),
            'bundle'
        );
    }
    
    protected function buildRouteResolver()
    {
        $components = $this->builder->components();
        
        return $components->route()->buildResolver(
            $this->configStorage()->slice('route.resolver'),
            $components->bundles()->routeResolvers()
        );
    }
    
    protected function buildTemplateLocator()
    {
        $components = $this->builder->components();
        
        return $components->filesystem()->buildLocator(
            $this->configStorage()->slice('template.locator'),
            $components->bundles()->templateLocators()
        );
    }
    
    protected function configStorage()
    {
        return $this->builder->assets()->configStorage();
    }
}