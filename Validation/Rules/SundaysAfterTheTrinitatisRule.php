<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace Hpc\Component\EcclesiasticalYear\Validation\Rules;


class SundaysAfterTheTrinitatisRule extends AbstractRules implements InterfaceRules
{
    const TWO_WEEKS_BEFORE_END_OF_YEAR = 15;


    /** @var int */
    protected $sundayAfterTrinitatis = 1;

    /** @var int */
    protected $countMaximumSundayAfterTrinitatis = 26;

    /** @var int */
    protected $dateMaximumSundayAfterTrinitatis;


    /**
     * @param string $input
     *
     * @return bool
     */
    public function checkDate($input)
    {
        $weekAsTimestamp = 7 * AbstractRules::SECONDS_PER_DAY;
        $this->calculateMaximumSundayAfterTrinitatis();
        $checkDateSunday = $this->dateTrinitatis + $weekAsTimestamp;
        $weekCount = 1;
        do
        {
            if ($checkDateSunday == $input)
            {
                $this->sundayAfterTrinitatis = $weekCount;
                $this->setName();
                return true;
            }

            $checkDateSunday += $weekAsTimestamp;
            $weekCount++;

        } while ($checkDateSunday < $this->dateMaximumSundayAfterTrinitatis || $weekCount >
            $this->countMaximumSundayAfterTrinitatis);

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
        $this->DateName = $this->sundayAfterTrinitatis . '. Sonntag nach Trinitatis';
    }

    /**
     *
     */
    private function calculateMaximumSundayAfterTrinitatis()
    {
        $this->dateMaximumSundayAfterTrinitatis = $this->dateEternitySunday - (self::TWO_WEEKS_BEFORE_END_OF_YEAR * AbstractRules::SECONDS_PER_DAY);
    }
}