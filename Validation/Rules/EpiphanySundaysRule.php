<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace Hpc\Component\EcclesiasticalYear\Validation\Rules;


class EpiphanySundaysRule extends AbstractRules implements InterfaceRules
{
    /** @var int */
    protected $prePassionSundays;

    /** @var int */
    protected $exitDate;

    /**
     * @param string $input
     *
     * @return bool
     */
    public function checkDate($input)
    {
        $maxWeekCount = 6;
        $weekCount = 1;
        $startDateAtEpiphanySunday = $this->getFirstEpiphanySundayDate()->getTimestamp();
        while ($weekCount <= $maxWeekCount)
        {
            if ($this->datePresentationOfJesusAtTheTemple > $startDateAtEpiphanySunday &&
                $startDateAtEpiphanySunday == $input)
            {
                $this->prePassionSundays = $weekCount;
                $this->exitDate = $startDateAtEpiphanySunday;
                $this->setName();
                return true;
            }
            $weekCount++;
            $startDateAtEpiphanySunday += (7 * self::SECONDS_PER_DAY);
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
        $differntDays = ($this->datePresentationOfJesusAtTheTemple - $this->exitDate) / self::SECONDS_PER_DAY;
        if ($differntDays <= 6)
        {
            $this->DateName = 'Letzter Sonntag nach Epiphanias';
        }
        else
        {
            $this->DateName = $this->prePassionSundays . '. Sonntag nach Epiphanias';
        }
    }

    private function getFirstEpiphanySundayDate()
    {
        return new \DateTime(date('Y-m-d', $this->dateEpiphany) . 'next Sunday 02:00:00');
    }
}