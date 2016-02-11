<?php

namespace PHPixie\BundleFramework;

use PHPixie\Processors\Processor;
use PHPixie\Slice\Data;

/**
 * Framework configuration
 */
class Configuration implements \PHPixie\Framework\Configuration
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var array
     */
    protected $instances = array();

    /**
     * Constructor
     * @param Builder $builder
     */
    public function __construct($builder)
    {
        $this->builder = $builder;
    }

    /**
     * Bundles configuration
     * @return Data
     */
    public function bundlesConfig()
    {
        return $this->instance('bundlesConfig');
    }

    /**
     * @inheritdoc
     */
    public function databaseConfig()
    {
        return $this->instance('databaseConfig');
    }

    /**
     * @inheritdoc
     */
    public function httpConfig()
    {
        return $this->instance('httpConfig');
    }

    /**
     * @inheritdoc
     */
    public function templateConfig()
    {
        return $this->instance('templateConfig');
    }

    /**
     * @inheritdoc
     */
    public function filesystemRoot()
    {
        return $this->builder->assets()->root();
    }

    /**
     * ORM configuration merger
     * @return Configuration\ORM
     */
    public function orm()
    {
        return $this->instance('orm');
    }

    /**
     * @inheritdoc
     */
    public function ormConfig()
    {
        return $this->orm()->configData();
    }

    /**
     * @inheritdoc
     */
    public function ormWrappers()
    {
        return $this->orm()->wrappers();
    }

    /**
     * @inheritdoc
     */
    public function authConfig()
    {
        return $this->instance('authConfig');
    }

    /**
     * @inheritdoc
     */
    public function authRepositories()
    {
        $components = $this->builder->components();
        return $components->bundles()->auth();
    }

    /**
     * @inheritdoc
     */
    public function httpProcessor()
    {
        return $this->instance('httpProcessor');
    }

    /**
     * @inheritdoc
     */
    public function httpRouteResolver()
    {
        return $this->instance('httpRouteResolver');
    }

    /**
     * @inheritdoc
     */
    public function templateLocator()
    {
        return $this->instance('templateLocator');
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }

    /**
     * @return Data
     */
    protected function buildBundlesConfig()
    {
        return $this->configStorage()->arraySlice('bundles');
    }

    /**
     * @return Data
     */
    protected function buildDatabaseConfig()
    {
        return $this->configStorage()->arraySlice('database');
    }

    /**
     * @return Data
     */
    protected function buildHttpConfig()
    {
        return $this->configStorage()->arraySlice('http');
    }

    /**
     * @return Data
     */
    protected function buildTemplateConfig()
    {
        return $this->configStorage()->arraySlice('template');
    }

    /**
     * @return Data
     */
    protected function buildAuthConfig()
    {
        return $this->configStorage()->arraySlice('auth');
    }

    /**
     * @return Configuration\ORM
     */
    protected function buildOrm()
    {
        $components = $this->builder->components();
        
        return new Configuration\ORM(
            $components->slice(),
            $components->bundles()->orm()
        );
    }

    /**
     * @return Processor
     */
    protected function buildHttpProcessor()
    {
        $components = $this->builder->components();
        
        return $components->httpProcessors()->attributeRegistryDispatcher(
            $components->bundles()->httpProcessors(),
            'bundle'
        );
    }

    /**
     * @return \PHPixie\Route\Resolvers\Resolver
     */
    protected function buildHttpRouteResolver()
    {
        $components = $this->builder->components();
        
        return $components->route()->buildResolver(
            $this->configStorage()->arraySlice('http.resolver'),
            $components->bundles()->routeResolvers()
        );
    }

    /**
     * @return Configuration\FilesystemLocator\Template
     */
    protected function buildTemplateLocator()
    {
        $components = $this->builder->components();
        $bundleLocators = $components->bundles()->templateLocators();
        
        $overridesLocator = null;
        
        $overridesConfig = $this->configStorage()->arraySlice('template.locator');
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

    /**
     * @return \PHPixie\Config\Storages\Type\Directory
     */
    protected function configStorage()
    {
        return $this->builder->assets()->configStorage();
    }
}
