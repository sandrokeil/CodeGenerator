<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

use Sake\CodeGenerator\Doctrine\ORM\Tools\Console\Command;

/**
 * Doctrine 2 console configuration example with Sake\CodeGenerator commands
 */

/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
chdir(__DIR__);

// load composer autoloading
if (!($loader = @include 'vendor/autoload.php')) {
    throw new RuntimeException('vendor/autoload.php could not be found. Did you run `php composer.phar install`?');
}

use Doctrine\ORM\Tools\Console\ConsoleRunner;

// Run the application!
$serviceManager = Zend\Mvc\Application::init(require 'config/application.config.php')->getServiceManager();


return ConsoleRunner::createHelperSet($serviceManager->get('doctrine.entitymanager.orm_default'));

// note that createApplication may be available in doctrine 2.5
/*
return ConsoleRunner::createApplication(
    $helperSet,
    new Command\GenerateFormCommand(),
    new Command\GenerateInputFilterCommand()
);
*/
