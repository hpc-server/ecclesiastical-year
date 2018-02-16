<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
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
