<?php

namespace PHPixie\Tests\BundleFramework;

/**
 * @coversDefaultClass \PHPixie\BundleFramework\Assets
 */
class AssetsTest extends \PHPixie\Tests\Framework\AssetsTest
{
    /**
     * @covers ::projectAssetsRoot
     * @covers ::<protected>
     */
    public function testProjectAssetsRoot()
    {
        $this->assets = $this->assetsMock(array('projectRoot'));
        $projectRoot  = $this->prepareRoot('projectRoot');
        
        $this->method($projectRoot, 'path', '/trixie', array('assets'), 0);
        $root = $this->preparebuildFilesystemRoot('/trixie');
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($root, $this->assets->projectAssetsRoot());
        }
    }
    
    /**
     * @covers ::projectWebRoot
     * @covers ::<protected>
     */
    public function testProjectWebRoot()
    {
        $this->assets = $this->assetsMock(array('projectRoot'));
        $projectRoot  = $this->prepareRoot('projectRoot');
        
        $this->method($projectRoot, 'path', '/trixie', array('web'), 0);
        $root = $this->preparebuildFilesystemRoot('/trixie');
        
        for($i=0; $i<2; $i++) {
            $this->assertSame($root, $this->assets->projectWebRoot());
        }
    }
    
    protected function assetsMock($methods = null)
    {
        if(!is_array($methods)) {
            $methods = array();
        }
        
        $methods[]= 'getProjectRootDirectory';
        
        return $this->getMock(
            '\PHPixie\BundleFramework\Assets',
            $methods,
            array($this->components)
        );
    }
}