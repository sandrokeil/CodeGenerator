<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Doctrine\ORM\Tools\Console\Command;

use Doctrine\ORM\EntityManager;
use Sake\CodeGenerator\Code\Generator\MetaData;
use Sake\CodeGenerator\Hydrator\DoctrineMetadata;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Doctrine\ORM\Tools\Console\MetadataFilter;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Doctrine\ORM\Mapping\Driver\DatabaseDriver;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;

/**
 * Abstract command class
 *
 * Base class for generate commands
 */
abstract class AbstractCommand extends Command
{
    /**
     * Configure command with default arguments
     */
    protected function configure()
    {
        $this->setDefinition(
            array(
                new InputOption(
                    'filter',
                    null,
                    InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                    'A string pattern used to match classes that should be processed.'
                ),
                new InputArgument(
                    'dest-path',
                    InputArgument::REQUIRED,
                    'The path to generate your classes.'
                ),
                new InputOption(
                    'force',
                    null,
                    InputOption::VALUE_NONE,
                    'Force to overwrite existing files.'
                ),
                new InputOption(
                    'from-database',
                    null,
                    null,
                    'Whether or not to convert mapping information from existing database.'
                ),
                new InputOption(
                    'extend',
                    null,
                    InputOption::VALUE_OPTIONAL,
                    'Defines a base class to be extended by generated classes.'
                ),
                new InputOption(
                    'namespace',
                    null,
                    InputOption::VALUE_OPTIONAL,
                    'Defines a namespace for this class.'
                ),
                new InputOption(
                    'num-spaces',
                    null,
                    InputOption::VALUE_OPTIONAL,
                    'Defines the number of indentation spaces',
                    4
                )
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getHelper('em')->getEntityManager();

        if ($input->getOption('from-database') === true) {
            $databaseDriver = new DatabaseDriver(
                $em->getConnection()->getSchemaManager()
            );

            $em->getConfiguration()->setMetadataDriverImpl(
                $databaseDriver
            );

            if (($namespace = $input->getOption('namespace')) !== null) {
                $databaseDriver->setNamespace($namespace);
            }
        }
        $doctrineMetaData = $this->getMetaData($em, $input);

        // Process destination directory
        if (!is_dir($destPath = $input->getArgument('dest-path'))) {
            mkdir($destPath, 0777, true);
        }
        $destPath = realpath($destPath);

        if (!file_exists($destPath)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Destination directory '<info>%s</info>' does not exist.",
                    $input->getArgument('dest-path')
                )
            );
        }

        if (!is_writable($destPath)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Destination directory '<info>%s</info>' does not have write permissions.",
                    $destPath
                )
            );
        }

        if (0 === count($doctrineMetaData)) {
            $output->writeln('No Metadata Classes to process.');
            return;
        }
        $generator = $this->getGenerator();

        if (($extend = $input->getOption('extend')) !== null) {
            $generator->setClassToExtend($extend);
        }

        if (($namespace = $input->getOption('namespace')) !== null) {
            $generator->setNamespace($extend);
        }
        if (($numSpaces = $input->getOption('num-spaces')) !== null) {
            $generator->setNumSpaces($numSpaces);
        }

        $metaData = array();
        $hydtrator = $this->getHydrator();

        foreach ($doctrineMetaData as $data) {
            $metaData[$data->name] = new MetaData($hydtrator->extract($data));
            $output->writeln(
                sprintf('Processing class "<info>%s</info>"', $data->name)
            );
        }

        $generator->generate($metaData, $destPath);

        // Outputting information message
        $output->writeln(PHP_EOL . sprintf('Classes generated to "<info>%s</INFO>"', $destPath));
    }

    /**
     * Returns metadata
     *
     * @param EntityManager $em
     * @param InputInterface $input
     * @return array
     */
    protected function getMetaData(EntityManager $em, InputInterface $input)
    {
        $cmf = new DisconnectedClassMetadataFactory();
        $cmf->setEntityManager($em);
        $metadata = $cmf->getAllMetadata();

        return MetadataFilter::filter($metadata, $input->getOption('filter'));
    }

    /**
     * @return \Sake\CodeGenerator\Code\Generator\AbstractGenerator
     */
    abstract protected function getGenerator();

    /**
     * Returns hydrator
     *
     * @return DoctrineMetadata
     */
    protected function getHydrator()
    {
        return new DoctrineMetadata();
    }
}
