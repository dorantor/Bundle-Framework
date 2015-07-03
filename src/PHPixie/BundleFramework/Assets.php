<?php

namespace PHPixie\BundleFramework;

abstract class Assets extends \PHPixie\Framework\Assets
{
    
   public function projectRoot()
    {
        return $this->instance('projectRoot');
    }
    
    public function projectAssetsRoot()
    {
        return $this->instance('projectAssetsRoot');
    }
    
    public function projectWebRoot()
    {
        return $this->instance('projectWebRoot');
    }
    
    protected function buildConfig()
    {
        $config = $this->components->config();
        
        return $this->config->directory(
            $this->assetsRoot()->path(),
            'config'
        );
    }
    
    protected function buildProjectRoot()
    {
        return $this->buildFilesystemRoot(
            $this->getProjectRootDirectory()
        );
    }
    
    protected function buildProjectAssetsRoot()
    {
        return $this->buildFilesystemRoot(
            $this->projectRoot()->path('assets')
        );
    }
    
    protected function buildProjectWebRoot()
    {
        return $this->buildFilesystemRoot(
            $this->projectRoot()->path('web')
        );
    }
    
    abstract protected function getProjectRootDirectory();
}