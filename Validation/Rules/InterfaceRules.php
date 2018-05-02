<?php
/**
 * User: stephansuess
 * @category    Arvato
 * @package     Arvato_
 * @copyright   Copyright (c) Arvato
 * @author      Stephan Suess
 * Date: 12.02.18
 * Time: 21:51
 */

namespace EcclesiasticalYear\Validation\Rules;

/**
 * Interface Rules
 * @package EcclesiasticalYear
 */
interface InterfaceRules
{
    /**
     * @param string $input
     *
     * @return bool
     */
    public function checkDate($input);

    /**
     * @return string
     */
    public function getFormatedDate();

    /**
     * @return string
     */
    public function getInputValue();
}