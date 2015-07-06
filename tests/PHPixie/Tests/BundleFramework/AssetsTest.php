<?php

namespace PHPixie\Tests\BundleFramework;

/**
 * @coversDefaultClass \PHPixie\BundleFramework\Assets
 */
class AssetsTest extends \PHPixie\Tests\Framework\AssetsTest
{
    /**
     * @covers ::root
     * @covers ::<protected>
     */
    public function testRoot()
    {
        $this->assets = $this->assetsMock(array('getRootDirectory'));
        $this->method($this->assets, 'getRootDirectory', '/trixie', array(), 0);
        $root = $this->preparebuildFilesystemRoot('/trixie');
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($root, $this->assets->root());
        }
    }
    
    /**
     * @covers ::assetsRoot
     * @covers ::<protected>
     */
    public function testAssetsRoot()
    {
        $this->assets = $this->assetsMock(array('root'));
        $root = $this->prepareRoot('root');
        
        $this->method($root, 'path', '/trixie', array('assets'), 0);
        $root = $this->preparebuildFilesystemRoot('/trixie');
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($root, $this->assets->assetsRoot());
        }
    }
    
    /**
     * @covers ::webRoot
     * @covers ::<protected>
     */
    public function testWebRoot()
    {
        $this->assets = $this->assetsMock(array('root'));
        $root = $this->prepareRoot('root');
        
        $this->method($root, 'path', '/trixie', array('web'), 0);
        $root = $this->preparebuildFilesystemRoot('/trixie');
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($root, $this->assets->webRoot());
        }
    }
    
    /**
     * @covers ::config
     * @covers ::<protected>
     */
    public function testConfig()
    {
        $this->assets = $this->assetsMock(array('assetsRoot'));
        $assetsRoot = $this->prepareRoot('assetsRoot');
        $config     = $this->prepareComponent('config');
        
        $this->method($assetsRoot, 'path', '/trixie', array(), 0);
        $configData = $this->quickMock('\PHPixie\Config\Storages\Type\Directory');
        
        $this->method($config, 'directory', $configData, array('/trixie', 'config'), 0);
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($configData, $this->assets->config());
        }
    }
    
    protected function assetsMock($methods = null)
    {
        if(!is_array($methods)) {
            $methods = array();
        }
        
        if(!in_array('getRootDirectory', $methods, true)) {
            $methods[]= 'getRootDirectory';
        }
        
        return $this->getMock(
            '\PHPixie\BundleFramework\Assets',
            $methods,
            array($this->components)
        );
    }
}