<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Doctrine\ORM\Tools\Console\Command;

use Sake\CodeGenerator\Code\Generator\InputFilterGenerator;

/**
 * Generate input filter command
 *
 * Generates zend input filter
 */
class GenerateInputFilterCommand extends AbstractCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        parent::configure();

        $this->setName('zf:generate-inputfilter')
            ->setDescription('Generates zend framework 2 input filter via doctrine 2')
            ->setHelp(
<<<EOT
Generates zend framework 2 input filter via doctrine 2
EOT
            );
    }

    /**
     * Returns input filter generator
     *
     * @return InputFilterGenerator
     */
    protected function getGenerator()
    {
        return new InputFilterGenerator();
    }
}
