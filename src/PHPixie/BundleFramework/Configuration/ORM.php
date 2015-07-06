<?php

namespace PHPixie\BundleFramework\Configuration;

class ORM
{
    protected $slice;
    protected $bundlesOrm;
    
    protected $instances = array();
    
    public function __construct($slice, $bundlesOrm)
    {
        $this->slice      = $slice;
        $this->bundlesOrm = $bundlesOrm;
    }
    
    public function configData()
    {
        return $this->instance('configData');
    }
    
    public function wrappers()
    {
        return $this->instance('wrappers');
    }
    
    protected function instance($name)
    {
        if(!array_key_exists($name, $this->instances)) {
            $method = 'build'.ucfirst($name);
            $this->instances[$name] = $this->$method();
        }
        
        return $this->instances[$name];
    }
    
    protected function buildConfigData()
    {
        $configMap = $this->bundlesOrm->configMap();
        
        $models = array();
        $relationships = array();
        
        foreach($configMap as $configData) {
            $modelsData = $configData->get('models', array());
            foreach($modelsData as $name => $modelData) {
                $models[$name] = $modelData;
            }
            
            $relationshipsData = $configData->get('relationships', array());
            foreach($relationshipsData as $relationshipData) {
                $relationships[] = $relationshipData;
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