<?php

namespace PHPixie\BundleFramework;

class ORM
{
    protected $slice;
    protected $bundlesOrm;
    protected $configData;
    
    protected $instances = array();
    
    public function __construct($slice, $bundlesOrm, $configData)
    {
        $this->slice      = $slice;
        $this->bundlesOrm = $bundlesOrm;
        $this->configData = $configData;
    }
    
    public function configData()
    {
        return $this->configData;
    }
    
    public function wrappers()
    {
        return $this->wrappers;
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildConfig()
    {
        $configMap = $this->bundlesOrm->configMap();
        
        $models = array();
        foreach($configMap as $configData) {
            $modelsData = $configData->get('models', array());
            foreach($modelsData as $name => $modelData) {
                $models[$key] => $modelData;
            }
        }
        
        $relationships = array();
        foreach($configMap as $configData) {
            $relationshipsData = $configData->get('relationships', array());
            foreach($relationshipsData as $relationshipData) {
                $relationships[] => $relationshipData;
            }
        }
        
        return $this->slice->arrayData(array(
            'models'        => $models,
            'relationships' => $relationships
        ));
    }
    
    protected function buildWrappers()
    {
        return new ORM\Wrappers($this->bundlesOrm);
    }
}