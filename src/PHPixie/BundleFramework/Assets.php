<?php

namespace PHPixie\BundleFramework;

abstract class Assets extends \PHPixie\Framework\Assets
{
    public function root()
    {
        return $this->instance('root');
    }
    
    public function assetsRoot()
    {
        return $this->instance('assetsRoot');
    }
    
    public function webRoot()
    {
        return $this->instance('webRoot');
    }
    
    public function config()
    {
        return $this->instance('config');
    }
    
    protected function buildRoot()
    {
        return $this->buildFilesystemRoot(
            $this->getRootDirectory()
        );
    }
    
    protected function buildAssetsRoot()
    {
        return $this->buildFilesystemRoot(
            $this->Root()->path('assets')
        );
    }
    
    protected function buildWebRoot()
    {
        return $this->buildFilesystemRoot(
            $this->Root()->path('web')
        );
    }
    
    protected function buildConfig()
    {
        $config = $this->components->config();
        
        return $config->directory(
            $this->assetsRoot()->path(),
            'config'
        );
    }
    
    abstract protected function getRootDirectory();
}