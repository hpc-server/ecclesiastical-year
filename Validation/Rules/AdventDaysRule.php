<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace Hpc\Component\EcclesiasticalYear\Validation\Rules;


class AdventDaysRule extends AbstractRules implements InterfaceRules
{
    /** @var int */
    protected $sundayAfterEternitySunday = 1;

    /** @var int */
    protected $countMaximumSundayAfterEternitySunday = 5;

    /** @var int */
    protected $dateMaximumSundayAfterEternitySunday;


    /**
     * @param string $input
     *
     * @return bool
     */
    public function checkDate($input)
    {
        $weekAsTimestamp = 7 * AbstractRules::SECONDS_PER_DAY;
        $this->calculateMaximumSundayAfterEternitySunday();
        $checkDateSunday = $this->dateEternitySunday + $weekAsTimestamp;
        $weekCount = 1;
        do
        {
            if ($checkDateSunday == $input)
            {
                $this->sundayAfterEternitySunday = $weekCount;
                $this->setName();
                return true;
            }

            $checkDateSunday += $weekAsTimestamp;
            $weekCount++;

        } while ($checkDateSunday < $this->dateMaximumSundayAfterEternitySunday || $weekCount >
            $this->countMaximumSundayAfterEternitySunday);

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
        $this->DateName = $this->sundayAfterEternitySunday . '. Advent';
    }

    /**
     *
     */
    private function calculateMaximumSundayAfterEternitySunday()
    {
        $this->dateMaximumSundayAfterEternitySunday = $this->dateChristmasEve;
    }
}