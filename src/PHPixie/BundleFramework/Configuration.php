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
    
    public function httpConfig()
    {
        return $this->instance('httpConfig');
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
    
    public function authConfig()
    {
        return $this->instance('authConfig');
    }
    
    public function authRepositories()
    {
        $components = $this->builder->components();
        return $components->bundles()->auth();
    }
    
    public function httpProcessor()
    {
        return $this->instance('httpProcessor');
    }
    
    public function httpRouteResolver()
    {
        return $this->instance('httpRouteResolver');
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
    
    protected function buildHttpConfig()
    {
        return $this->configStorage()->slice('http');
    }
    
    protected function buildTemplateConfig()
    {
        return $this->configStorage()->slice('template');
    }
    
    protected function buildAuthConfig()
    {
        return $this->configStorage()->slice('auth');
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
    
    protected function buildHttpRouteResolver()
    {
        $components = $this->builder->components();
        
        return $components->route()->buildResolver(
            $this->configStorage()->slice('http.resolver'),
            $components->bundles()->routeResolvers()
        );
    }
    
    protected function buildTemplateLocator()
    {
        $components = $this->builder->components();
        $bundleLocators = $components->bundles()->templateLocators();
        
        $overridesLocator = null;
        
        $overridesConfig = $this->configStorage()->slice('template.locator');
        if($overridesConfig->get('type') !== null) {
            $overridesLocator = $components->filesystem()->buildLocator(
                $overridesConfig,
                $bundleLocators
            );
        }
        
        return new Configuration\FilesystemLocator\Template(
            $bundleLocators,
            $this->builder->assets(),
            $overridesLocator    
        );
    }
    
    protected function configStorage()
    {
        return $this->builder->assets()->configStorage();
    }
}
