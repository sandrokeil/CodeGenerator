<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Code\Generator;

use Zend\Code\Generator\FileGenerator;

/**
 * Abstract generator
 *
 * Provides common generator functions
 */
abstract class AbstractGenerator
{
    /**
     * FCQN of class to extends
     *
     * @var string
     */
    protected $classToExtend;

    /**
     * Namespace
     *
     * @var string
     */
    protected $namespace = 'CodeGenerator';

    /**
     * Number of spaces
     *
     * @var int
     */
    protected $numSpaces = 4;

    /**
     * Generates and writes classes for the given array of ClassMetadataInfo instances.
     *
     * @param array  $metadatas
     * @param string $outputDirectory
     */
    public function generate(array $metadatas, $outputDirectory)
    {
        foreach ($metadatas as $metadata) {
            $this->writeClass($metadata, $outputDirectory);
        }
    }

    /**
     * Generates and writes class to disk for the given ClassMetadataInfo instance.
     *
     * @param MetaData $metadata
     * @param string            $outputDirectory
     */
    public function writeClass(MetaData $metadata, $outputDirectory)
    {
        $path = $outputDirectory . '/'
            . str_replace('\\', DIRECTORY_SEPARATOR, $this->getName($metadata))
            . '.php';

        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($path, $this->generateClass($metadata)->generate());
    }

    /**
     * Sets class which generated class should extend
     *
     * @param string $classToExtend
     */
    public function setClassToExtend($classToExtend)
    {
        $this->classToExtend = $classToExtend;
    }

    /**
     * Sets namespace for generated class
     *
     * @param string $namespace
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    /**
     * Converts name
     *
     * @param string $name
     * @return string
     */
    protected function convertName($name)
    {
        return ucfirst($name);
    }

    /**
     * Sets intendation
     *
     * @param int $numSpaces
     */
    public function setNumSpaces($numSpaces)
    {
        $this->numSpaces = $numSpaces;
    }

    /**
     * Returns intendation depending on loops
     *
     * @param int $number Number of loops
     * @return string
     */
    protected function getIntendation($number = 1)
    {
        $indentation = '';

        for ($i = 0; $i < $number; $i++) {
            $indentation .= str_pad('', $this->numSpaces, ' ');
        }
        return $indentation;
    }

    /**
     * Generates class
     *
     * @param MetaData $metadata
     * @return FileGenerator
     */
    abstract public function generateClass(MetaData $metadata);

    /**
     * Returns file name for specifc generated type
     *
     * @param MetaData $metadata
     * @return string
     */
    abstract public function getName(MetaData $metadata);
}
