<?php
/**
 * User: stephansuess
 * @category    Arvato
 * @package     Arvato_
 * @copyright   Copyright (c) Arvato
 * @author      Stephan Suess
 * Date: 12.02.18
 * Time: 21:57
 */

namespace EcclesiasticalYear\Validation\Rules;


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