<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Hydrator;

use Doctrine\ORM\Mapping\MetaData;
use Zend\Stdlib\Hydrator\HydratorInterface;
use Sake\CodeGenerator\Exception;

/**
 * Doctrine meta data hydrator
 *
 * Hydrates doctrine meta data for our generator meta data object
 */
class DoctrineMetadata implements HydratorInterface
{
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     */
    public function extract($object)
    {
        if (!$object instanceof MetaData) {
            return array();
        }

        $mapped = array(
            'columns' => array(),
            'foreignKeys' => array()
        );

        $mapped['name'] = $object->name;
        $mapped['table'] = $object->table;

        foreach ($object->fieldMappings as $name => $data) {
            $mapped['columns'][$name] = $data;
        }
        foreach ($object->associationMappings as $name => $data) {
            $mapped['foreignKeys'][$name] = $data;
        }

        return $mapped;
    }

    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return object
     */
    public function hydrate(array $data, $object)
    {
        throw new Exception\RuntimeException('Hydration is not implemented yet');
    }
}
