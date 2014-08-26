<?php
/**
 * Sake
 *
 * @link      http://github.com/sandrokeil/CodeGenerator for the canonical source repository
 * @copyright Copyright (c) 2014 Sandro Keil
 * @license   http://github.com/sandrokeil/CodeGenerator/blob/master/LICENSE.txt New BSD License
 */

namespace Sake\CodeGenerator\Exception;

/**
 * Runtime exception
 *
 * Use this exception if the code has not the capacity to handle the request.
 */
class RuntimeException extends \RuntimeException implements ExceptionInterface
{
}
