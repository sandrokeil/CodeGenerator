<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Code\Generator;

use Sake\CodeGenerator\Code\Metadata\MetadataInfo;
use Zend\Code\Generator\DocBlock\Tag;
use Zend\Code\Generator\DocBlockGenerator;
use Zend\Code\Generator\FileGenerator;
use Zend\Code\Generator\ClassGenerator;
use Zend\Code\Generator\MethodGenerator;

/**
 * Form generator
 *
 * Generates zend framework 2 form depending on given meta data (table or entity definitions).
 */
class FormGenerator extends AbstractGenerator
{
    /**
     * FCQN of class to extends
     *
     * @var string
     */
    protected $classToExtend = '\Zend\Form\Fieldset';

    /**
     * Namespace
     *
     * @var string
     */
    protected $namespace = 'Form\Fieldset';

    /**
     * Returns file name for specifc generated type
     *
     * @param MetadataInfo $metadata
     * @return string
     */
    public function getName(MetadataInfo $metadata)
    {
        return 'Form/Fieldset/' . $this->convertName($metadata->getTable('name'));
    }

    /**
     * Generates zend form class
     *
     * @param MetadataInfo $metadata
     * @return FileGenerator
     */
    public function generateClass(MetadataInfo $metadata)
    {
        $methods = array($this->getInitMethod($metadata), );

        foreach ($metadata->getColumns() as $name => $data) {
            // dont add primary keys
            if (!empty($data['id'])) {
                continue;
            }
            $methods[] = $this->getAddMethod($data);
        }
        foreach ($metadata->getForeignKeys() as $name => $data) {
            // dont add foreign key definition
            if (8 === $data['type']) {
                continue;
            }
            $methods[] = $this->getAddMethodForAssociation($data);
        }

        $file = new FileGenerator(array(
            'classes' => array(
                new ClassGenerator(
                    $metadata->getName(),
                    'Form',
                    null,
                    $this->classToExtend,
                    array(
                        'InitializableInterface'
                    ),
                    array(),
                    $methods,
                    new DocBlockGenerator(
                        'Form fieldset for ' . $metadata->getName(),
                        'This fieldset can be used to build complex forms for ' . $metadata->getName()
                    )
                ),
            ),
            'namespace' => $this->namespace,
            'uses' => array(
                '\Zend\Stdlib\InitializableInterface'
            ),
            'docBlock' => new DocBlockGenerator(
                'Generated by Sake\CodeGenerator http://github.com/sandrokeil/CodeGenerator'
            )
        ));
        return $file;
    }

    /**
     * Generate form init method which calls add functions.
     *
     * @param MetadataInfo $metadataInfo
     * @return MethodGenerator
     */
    protected function getInitMethod(MetadataInfo $metadataInfo)
    {
        $body = '';

        foreach ($metadataInfo->getColumns() as $name => $data) {
            // dont add primary keys
            if (!empty($data['id'])) {
                continue;
            }
            $body .= '$this->addElement' . $this->convertName($data['columnName']) . '();' . PHP_EOL;
        }
        foreach ($metadataInfo->getForeignKeys() as $name => $data) {
            // dont add foreign key definition
            if (8 === $data['type']) {
                continue;
            }
            $body .= '$this->addElement' . $this->convertName($data['fieldName']) . '();' . PHP_EOL;
        }

        return new MethodGenerator(
            'init',
            array(),
            MethodGenerator::FLAG_PUBLIC,
            $body,
            new DocBlockGenerator('Initialize form elements')
        );
    }

    /**
     * Returns the form element type depending on table information.
     *
     * @param array $metadata Field metadata
     * @return string Element type
     */
    protected function getElementType(array $metadata)
    {
        switch ($metadata['type']) {
            case 'text':
                $type = 'textarea';
                break;

            default:
                $type = 'text';
                break;
        }
        return $type;
    }

    /**
     * Returns add methods for foreign keys
     *
     * @param array $data
     * @return MethodGenerator
     */
    protected function getAddMethodForAssociation(array $data)
    {
        $name = $this->convertName($data['fieldName']);
        $attributes = "array('id' => '" . $name . "')";

        $body = <<<'EOT'
    $this->add(
    array(
        'type' => '%s',
        'name' => '%s',
        'options' => array(
            'label' => '%s',
            'empty_option' => 'Please choose %s',
            'object_manager' => $this->getObjectManager(),
            'target_class' => '%s',
            'property' => '%s',
        ),
        'attributes' => %s,
    )
);

EOT;

        $body = sprintf(
            $body,
            'DoctrineORMModule\Form\Element\EntitySelect',
            lcfirst($name),
            $name,
            $name,
            $data['targetEntity'],
            '[SET PROPERTY NAME FOR TEXT]',
            $attributes
        );
        return new MethodGenerator(
            'addElement' . $name,
            array(),
            MethodGenerator::FLAG_PROTECTED,
            $body,
            new DocBlockGenerator(sprintf('Adds element %s to form, it is a foreign key', lcfirst($name)))
        );
    }

    /**
     * Returns add method with element defintion
     *
     * @param array $data
     * @return MethodGenerator
     */
    protected function getAddMethod(array $data)
    {
        $name = $this->convertName($data['columnName']);
        $options = "array('label' => '" . $name . "')";
        $attributes = "array('id' => '" . $name . "')";

        $body = <<<'EOT'
    $this->add(
    array(
        'type' => '%s',
        'name' => '%s',
        'options' => %s,
        'attributes' => %s,
    )
);

EOT;

        return new MethodGenerator(
            'addElement' . $name,
            array(),
            MethodGenerator::FLAG_PROTECTED,
            sprintf($body, $this->getElementType($data), lcfirst($name), $options, $attributes),
            new DocBlockGenerator(sprintf('Adds element %s to form', lcfirst($name)))
        );
    }
}
