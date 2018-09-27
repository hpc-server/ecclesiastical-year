<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace Hpc\Component\EcclesiasticalYear\Validation\Rules;


class PrePassionSundaysRule extends AbstractRules implements InterfaceRules
{
    /** @var int */
    protected $prePassionSundays;

    /**
     * @param string $input
     *
     * @return bool
     */
    public function checkDate($input)
    {
        $checkDate[4] = $this->dateEaster - (70 * self::SECONDS_PER_DAY);
        $checkDate[5] = $this->dateEaster - (77 * self::SECONDS_PER_DAY);

        foreach ($checkDate as $weekCount => $date)
        {
            if ($this->datePresentationOfJesusAtTheTemple < $date && $date == $input)
            {
                $this->prePassionSundays = $weekCount;
                $this->setName();
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getFormatedDate()
    {
        return $this->formatDate();
    }

    /**
     * Setteer for date name
     */
    protected function setName()
    {
        $this->DateName = $this->prePassionSundays . '. Sonntag vor der Passionszeit';
    }
}