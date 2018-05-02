<?php
/**
 * User: stephansuess
 * @category    Arvato
 * @package     Arvato_
 * @copyright   Copyright (c) Arvato
 * @author      Stephan Suess
 * Date: 15.02.18
 * Time: 18:17
 */

namespace EcclesiasticalYear\Validation;


use EcclesiasticalYear\Validation\Exceptions\ModuleException;
use ReflectionClass;

class Factory
{
    const SUFFIX = 'Rule';

    const PREFIX = 'EcclesiasticalYear\\Validation\\Rules\\';



    /**
     * @param $ruleName
     *
     * @return object
     * @throws ModuleException
     */
    public function build($ruleName)
    {
        $className = self::PREFIX . $ruleName . self::SUFFIX;
        if (!class_exists($className)) {
            throw new ModuleException(sprintf('"%s" is not a valid rule!', $className));
        }

        $reflection = new ReflectionClass($className);
        if (!$reflection->isSubclassOf('EcclesiasticalYear\\Validation\\Rules\\InterfaceRules')) {
            throw new ModuleException(sprintf('"%s" is not a valid rule!', $className));
        }

        return $reflection->newInstanceArgs();
    }
}