<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace SakeTest\CodeGenerator;

use \Sake\CodeGenerator\Module;

/**
 * Class ModuleTest
 *
 * Tests integrity of \Sake\CodeGenerator\Module
 */
class ModuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests getConfig() should should return view helper configuration
     *
     * @covers \Sake\CodeGenerator\Module::getConfig
     */
    public function testGetConfig()
    {
        $cut = new Module();
        $config = $cut->getConfig();
        $this->assertSame(
            @include 'config/module.config.php',
            $config,
            'Module configuration could not be read'
        );
    }
}
