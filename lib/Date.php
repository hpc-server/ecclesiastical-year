<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace EcclesiasticalYear\Validation;

use EcclesiasticalYear\Validation\Exceptions\ModuleException;
use EcclesiasticalYear\Validation\Rules\InterfaceRules;

class Date implements InterfaceRules
{

    private $rulesArrayByNames = [
        'EasterDay',
        'MaundyThursday'
    ];

    private $rulesArrayByObjects = [];

    protected static $factory;


    public function __construct()
    {
        try
        {
            $this->loadRules();
        }
        catch (ModuleException $e)
        {

        }
    }

    /**
     * @return Factory
     */
    protected static function getFactory()
    {
        if (!static::$factory instanceof Factory) {
            static::$factory = new Factory();
        }

        return static::$factory;
    }

    /**
     * @param string $input
     *
     * @return bool|InterfaceRules
     */
    public function checkDate($input)
    {
        /**
         * @var string $ruleName
         * @var InterfaceRules $ruleObject
         */
        foreach ($this->rulesArrayByObjects as $ruleName => $ruleObject)
        {
            if ($ruleObject->checkDate($input))
            {
                return $ruleObject;
            }
        }
        return false;
    }

    /**
     */
    public function getFormatedDate()
    {
        // @inherit
    }

    /**
     */
    public function getInputValue()
    {
        // @inherit
    }

    /**
     * @throws ModuleException
     */
    private function loadRules()
    {
        try
        {
            foreach ($this->rulesArrayByNames as $ruleName)
            {
                $this->rulesArrayByObjects[$ruleName] = static::getFactory()->build($ruleName);
            }
        }
        catch (\Exception $exception)
        {
            throw new ModuleException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
