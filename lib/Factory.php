<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
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
