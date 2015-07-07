<?php

namespace PHPixie\BundleFramework;

class Assets extends \PHPixie\Framework\Assets
{
    protected $rootDirectory;
    
    public function __construct($builder, $rootDirectory)
    {
        $this->rootDirectory = $rootDirectory;
        
        parent::__construct($builder);
    }
    
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
    
    public function configStorage()
    {
        return $this->instance('configStorage');
    }
    
    protected function buildRoot()
    {
        return $this->buildFilesystemRoot(
            $this->rootDirectory
        );
    }
    
    protected function buildAssetsRoot()
    {
        return $this->buildFilesystemRoot(
            $this->root()->path('assets')
        );
    }
    
    protected function buildWebRoot()
    {
        return $this->buildFilesystemRoot(
            $this->root()->path('web')
        );
    }
    
    protected function buildConfigStorage()
    {
        $config = $this->components->config();
        
        return $config->directory(
            $this->assetsRoot()->path(),
            'config'
        );
    }
}