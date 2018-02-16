<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace EcclesiasticalYear\Validation\Rules;

class EasterDayRule extends AbstractRules implements InterfaceRules
{
    /**
     * @param string $input
     *
     * @return bool
     */
    public function checkDate($input)
    {
        $this->inputValue = $input;
        $this->setName();
        return ($this->inputValue == easter_date(date('Y')));
    }

    /**
     * @return string
     */
    public function getFormatedDate()
    {
        return date('l, d.m.Y', $this->inputValue) . ' - ' . $this->DateName;
    }

    /**
     * Setteer for date name
     */
    protected function setName()
    {
        $this->DateName = 'Ostersonntag';
    }
}
