<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * This class initializes the CodeGenerator module.
 */
class Module implements ConfigProviderInterface
{
    /**
     * Expected to return \Zend\ServiceManager\Config object or array to
     * seed such an object.
     *
     * @return array
     */
    public function getConfig()
    {
        return require dirname(__DIR__) . '/config/module.config.php';
    }
}
