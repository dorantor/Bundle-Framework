<?php

namespace PHPixie\Framework\Environment;

class RouteRegistry implements \PHPixie\Router\Routes\Registry
{
    protected $bundles;
    
    public function __construct($bundles)
    {
        $this->bundles = $bundle;
    }
    
    public function get($name)
    {
        $path = explode('.', $name, 2);
        $bundle = $this->bundles->get($path[0]);
        $routeResolver = $bundle->routeResolver();
        
        if(count($path) > 1) {
            $routeResolver->get($path[1]);
        }
        
        return $routeResolver;
    }
}   