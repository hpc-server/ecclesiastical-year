<?php
/**
 * User: stephansuess
 * @category    Arvato
 * @package     Arvato_
 * @copyright   Copyright (c) Arvato
 * @author      Stephan Suess
 * Date: 12.02.18
 * Time: 22:12
 */

namespace EcclesiasticalYear\Validation\Rules;




class MaundyThursdayRule extends AbstractRules implements InterfaceRules
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
        return ($this->inputValue == (easter_date(date('Y'))) - (3 * AbstractRules::SECONDS_PER_DAY));
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
        $this->DateName = 'Gründonnerstag';
    }
}