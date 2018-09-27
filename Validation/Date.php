<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace Hpc\Component\EcclesiasticalYear\Validation;

use Hpc\Component\EcclesiasticalYear\Validation\Exceptions\ModuleException;
use Hpc\Component\EcclesiasticalYear\Validation\Rules\InterfaceRules;

class Date implements InterfaceRules
{
    const RULES_FILE_PATTERN = "/(.*)Rule.php/";

    const RULES_DIRECTORY = 'Rules';

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
            $ruleObject->initRule($input);

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
            foreach ($this->loadRuleClasses() as $ruleName)
            {
                $this->rulesArrayByObjects[$ruleName] = static::getFactory()->build($ruleName);
            }
        }
        catch (\Exception $exception)
        {
            throw new ModuleException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }

    /**
     * @return array
     */
    private function loadRuleClasses()
    {
        $ruleClasses = [];
        $files = scandir(__DIR__ . DIRECTORY_SEPARATOR . self::RULES_DIRECTORY);
        foreach ($files as $file)
        {
            if (preg_match(self::RULES_FILE_PATTERN, $file, $match))
            {
                $ruleClasses[] = $match[1];
            }
        }
        return $ruleClasses;
    }
}