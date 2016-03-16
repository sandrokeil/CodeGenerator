<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator;

use Sake\CodeGenerator\Doctrine\ORM\Tools\Console\Command\GenerateFormCommand;
use Sake\CodeGenerator\Doctrine\ORM\Tools\Console\Command\GenerateInputFilterCommand;
use Zend\ModuleManager\Feature\ConfigProviderInterface;

/**
 * This class initializes the CodeGenerator module.
 */
class Module implements ConfigProviderInterface
{

    /**
     * {@inheritDoc}
     */
    public function init(ModuleManager $e)
    {
        $events = $e->getEventManager()->getSharedManager();
        // Attach to helper set event and load the entity manager helper.
        $events->attach('doctrine', 'loadCli.post', function (EventInterface $e) {
            /* @var $cli \Symfony\Component\Console\Application */
            $cli = $e->getTarget();
            ConsoleRunner::addCommands($cli);
            $cli->addCommands(array(
                new GenerateFormCommand(),
                new GenerateInputFilterCommand()
            ));
        });
    }


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
