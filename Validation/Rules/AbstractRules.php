<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace Hpc\Component\EcclesiasticalYear\Validation\Rules;


abstract class AbstractRules
{
    public $DateName;

    public $inputValue;

    const SECONDS_PER_DAY = 86400;


    /**
     * Setteer for date name
     */
    abstract protected function setName();

    /**
     * @return string
     */
    public function getInputValue()
    {
        return $this->inputValue;
    }
}