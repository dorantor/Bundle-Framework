<?php

namespace PHPixie\Tests\Framework\Bundles\ORM;

/**
 * @coversDefaultClass \PHPixie\Framework\Bundles\ORM\Wrappers
 */
class WrappersTest extends \PHPixie\Test\Testcase
{
    protected $wrappers;
    
    protected $bundleMap = array();
    protected $wrappersMap = array();
    
    protected $typeSuffixes = array(
        'databaseRepositories' => 'Repository',
        'databaseQueries'      => 'Query',
        'databaseEntities'     => 'Entity',
        'embeddedEntities'     => 'Embedded'
    );
    
    public function setUp()
    {
        $ormWrappersBundles = array();
        
        $bundleNames = array('trixie', 'stella');
        foreach($bundleNames as $name) {
            $bundle = $this->quickMock('\PHPixie\Framework\Bundles\Bundle\Provides\ORMWrappers');
            $ormWrappersBundles[] = $bundle;
            
            $this->method($bundle, 'name', $name, array());
            
            $wrappers = $this->quickMock('\PHPixie\ORM\Wrappers');
            $this->method($bundle, 'ormWrappers', $wrappers, array());
            $this->wrappersMap[$name] = $wrappers;
            
            foreach($this->typeSuffixes as $type => $suffix) {
                $return = array($name.$suffix.'1', $name.$suffix.'2');
                $this->method($wrappers, $type, $return, array());
            }
        }
        
        $this->wrappers = new \PHPixie\Framework\Bundles\ORM\Wrappers(
            $ormWrappersBundles
        );
    }
    
    /**
     * @covers ::__construct
     */
    public function testConstruct()
    {
    
    }
    
    /**
     * @covers ::databaseRepositories
     * @covers ::databaseQueries
     * @covers ::databaseEntities
     * @covers ::embeddedEntities
     * @covers ::<protected>
     */
    public function testModelNames()
    {
        foreach($this->typeSuffixes as $type => $suffix) {
            $expect = array();
            foreach(array_keys($this->wrappersMap) as $bundleName) {
                $expect[]=$bundleName.$suffix.'1';
                $expect[]=$bundleName.$suffix.'2';
            }
            
            $this->assertSame($expect, $this->wrappers->$type());
        }
        
        $this->wrappers = new \PHPixie\Framework\Bundles\ORM\Wrappers();
        foreach(array_keys($this->typeSuffixes) as $type) {
            $this->assertSame(array(), $this->wrappers->$type());
        }
    }
    
    /**
     * @covers ::databaseRepositoryWrapper
     * @covers ::databaseQueryWrapper
     * @covers ::databaseEntityWrapper
     * @covers ::embeddedEntityWrapper
     * @covers ::<protected>
     */
    public function testWrappers()
    {
        $methodClasses = array(
            'databaseRepositories' => 'Database\Repository',
            'databaseQueries'      => 'Database\Query',
            'databaseEntities'     => 'Database\Entity',
            'embeddedEntities'     => 'Embedded\Entity'
        );
        
        $wrapperMethods = array(
            'databaseRepositories' => 'databaseRepositoryWrapper',
            'databaseQueries'      => 'databaseQueryWrapper',
            'databaseEntities'     => 'databaseEntityWrapper',
            'embeddedEntities'     => 'embeddedEntityWrapper'
        );
        
        foreach($this->typeSuffixes as $type => $suffix) {
            $class = $methodClasses[$type];
            $method = $wrapperMethods[$type];
            
            foreach(array_keys($this->wrappersMap) as $bundleName) {
                $wrapped = $this->quickMock('\PHPixie\ORM\Models\Type\\'.$class);
                $wrapper = $this->quickMock('\PHPixie\ORM\Wrappers\Type\\'.$class);
            
                $this->method($wrapped, 'modelName', $bundleName.$suffix.'1', array(), 0);
                
                $wrappers = $this->wrappersMap[$bundleName];
                $this->method($wrappers, $method, $wrapper, array($wrapped), 0);
                
                $this->assertSame($wrapper, $this->wrappers->$method($wrapped));
            }
        }
    }
}