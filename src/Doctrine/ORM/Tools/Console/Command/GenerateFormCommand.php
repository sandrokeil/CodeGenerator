<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Doctrine\ORM\Tools\Console\Command;

use Sake\CodeGenerator\Code\Generator\CodeGenerator;

/**
 * Generate form command
 *
 * Generates zend form
 */
class GenerateFormCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('zf:generate-form')
            ->setAliases(array('zf:generate:form'))
            ->setDescription('Generates zend framework 2 form via doctrine')
            ->setHelp(
<<<EOT
Generates zend framework 2 form via doctrine
EOT
            );
    }

    /**
     * Returns form generator
     *
     * @return CodeGenerator
     */
    protected function getGenerator()
    {
        return new CodeGenerator();
    }
}
