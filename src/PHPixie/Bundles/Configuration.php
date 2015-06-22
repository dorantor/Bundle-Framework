<?php

namespace PHPixie\Bundles;

class Configuration
{
    protected function buildRouteResolver()
    {
        $routeConfig = $this->configData->slice('routes');
        $routeRegistry = $this->builder->routeRegistry();
        return $this->route()->buildResolver($routeConfig, $routeRegistry);
    }
}