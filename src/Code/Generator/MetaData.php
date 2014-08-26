<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Code\Generator;

use Zend\Stdlib\AbstractOptions;

/**
 * Code generator meta data
 *
 * Contains table/entity/class definitions to generate several classes
 */
class MetaData extends AbstractOptions
{
    /**
     * @var array
     */
    protected $table = array();

    /**
     * @var array
     */
    protected $columns = array();

    /**
     * @var array
     */
    protected $foreignKeys = array();

    /**
     * @var string
     */
    protected $name;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Returns foreign keys data
     *
     * @param string $key Key, if not provided, complete array will be returned
     * @return array
     */
    public function getForeignKeys($key = null)
    {
        if (null !== $key) {
            return $this->foreignKeys[$key];
        }
        return $this->foreignKeys;
    }

    /**
     * @param array $foreignKeys
     */
    public function setForeignKeys(array $foreignKeys)
    {
        $this->foreignKeys = $foreignKeys;
    }

    /**
     * Returns columns data
     *
     * @param string $key Key, if not provided, complete array will be returned
     * @return array
     */
    public function getColumns($key = null)
    {
        if (null !== $key) {
            return $this->columns[$key];
        }
        return $this->columns;
    }

    /**
     * @param array $columns
     */
    public function setColumns(array $columns)
    {
        $this->columns = $columns;
    }

    /**
     * Returns table data
     *
     * @param string $key Key, if not provided, complete array will be returned
     * @return array
     */
    public function getTable($key = null)
    {
        if (null !== $key) {
            return $this->table[$key];
        }
        return $this->table;
    }

    /**
     * @param array $table
     */
    public function setTable(array $table)
    {
        $this->table = $table;
    }
}
