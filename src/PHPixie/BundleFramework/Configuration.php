<?php

namespace PHPixie\Bundles;

class Configuration
{
    protected function buildRouteResolver()
    {
        $routeConfig = $this->configData()->slice('routes');
        $routeRegistry = $this->builder->routeRegistry();
        return $this->route()->buildResolver($routeConfig, $routeRegistry);
    }
    
    protected function buildFilesystemLocator()
    {
        $locatorConfig = $this->configData()->slice('filesystem');
        $locatorRegistry = $this->builder->locatorRegistry();
        return $this->filesystem()->buildLocator($locatorConfig, $locatorRegistry);
    }
    
    protected function buildConfigData()
    {
        $config = $this->builder->components->config();
        $directory = $this->filesystemRoot()->path('assets');
        return $config->directory($directory, 'config');
    }
    
    
}