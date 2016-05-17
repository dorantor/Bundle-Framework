<?php

namespace PHPixie\Tests\BundleFramework;

/**
 * @coversDefaultClass \PHPixie\BundleFramework\Assets
 */
class AssetsTest extends \PHPixie\Tests\Framework\AssetsTest
{
    protected $rootDirectory = '/trixie';
    protected $parameterFile;

    public function setUp()
    {
        $this->parameterFile = sys_get_temp_dir().'/params.php';
        parent::setUp();
    }

    public function tearDown()
    {
        if(file_exists($this->parameterFile)) {
            unlink($this->parameterFile);
        }
    }

    /**
     * @covers ::root
     * @covers ::<protected>
     */
    public function testRoot()
    {
        $this->assets = $this->assetsMock(array('getRootDirectory'));
        $root = $this->preparebuildFilesystemRoot($this->rootDirectory);
        
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
     * @covers ::configStorage
     * @covers ::<protected>
     */
    public function testConfigStorage()
    {
        $this->assets = $this->assetsMock(array('assetsRoot'));
        $assetsRoot = $this->prepareRoot('assetsRoot');
        $config     = $this->prepareComponent('config');
        
        $this->method($assetsRoot, 'path', '/trixie', array(), 0);
        $configData = $this->quickMock('\PHPixie\Config\Storages\Type\Directory');
        
        $this->method($config, 'directory', $configData, array('/trixie', 'config'), 0);
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($configData, $this->assets->configStorage());
        }
    }

    /**
     * @covers ::parameterStorage
     * @covers ::<protected>
     */
    public function testNullParameterStorage()
    {
        $this->assets = $this->assetsMock(array('assetsRoot'));
        $assetsRoot = $this->prepareRoot('assetsRoot');

        $this->method($assetsRoot, 'path', 'non-existing', array('parameters.php'), 0);

        for($i=0; $i<2; $i++) {
            $this->assertSame(null, $this->assets->parameterStorage());
        }
    }

    /**
     * @covers ::parameterStorage
     * @covers ::<protected>
     */
    public function testParameterStorage()
    {
        file_put_contents($this->parameterFile, '');

        $this->assets = $this->assetsMock(array('assetsRoot'));
        $assetsRoot = $this->prepareRoot('assetsRoot');
        $config     = $this->prepareComponent('config');

        $this->method($assetsRoot, 'path', $this->parameterFile, array('parameters.php'), 0);
        $configData = $this->quickMock('\PHPixie\Config\Storages\Type\File');

        $this->method($config, 'file', $configData, array($this->parameterFile), 0);

        for($i=0; $i<2; $i++) {
            $this->assertSame($configData, $this->assets->parameterStorage());
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
            array(
                $this->components,
                $this->rootDirectory
            )
        );
    }
}