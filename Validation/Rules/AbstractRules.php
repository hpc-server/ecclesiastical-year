<?php
/**
 * @category    hpc-server
 * @package     EcclesiasticalYear_Validation
 * @copyright   Copyright (c) HPC
 * @author      Stephan Suess
 */

namespace Hpc\Component\EcclesiasticalYear\Validation\Rules;


use DateTime;
use IntlDateFormatter;
use phpDocumentor\Reflection\Types\Self_;

abstract class AbstractRules
{
    /** @var int */
    const SECONDS_PER_DAY = 86400;


    const TWO_OCLOCK_AT_NIGHT = ' 02.00.00';


    /** @var string */
    protected $DateName;

    /** @var int */
    protected $inputValue;

    /** @var string */
    protected $year;

    /** @var int */
    protected $dateChristmasEve;

    /** @var int */
    protected $dateEternitySunday;

    /** @var int */
    protected $dateEaster;

    /** @var int */
    protected $datePentecost;

    /** @var int */
    protected $dateTrinitatis;

    /** @var int */
    protected $dateNewYearsEve;

    /** @var  */
    protected $dateEpiphany;

    /** @var int */
    protected $datePresentationOfJesusAtTheTemple;


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

    /**
     * @param $input
     */
    public function initRule($input)
    {
        $this->inputValue = $input;
        $this->year = $this->calculateYearBasedByInputValue();
        $this->dateChristmasEve = $this->calculateChristmasEveBasedByYear();
        $this->dateNewYearsEve = $this->calculateNewYearsEveBasedByYear();
        $this->dateEpiphany = $this->calculateEpiphanyBasedByYear();
        $this->dateEaster = $this->calculateEasterDateBasedByYear();
        $this->datePresentationOfJesusAtTheTemple = $this->calculatePresentationOfJesusAtTheTempleByYear();
        $this->datePentecost = $this->calculatePentecostBasedByEasterDate();
        $this->dateTrinitatis = $this->calculatePentecostBasedByPentecost();
        $this->dateEternitySunday = $this->calculateEternitySundayBasedByCristmasEve();
    }

    /**
     * @return string
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * @return false|string
     */
    private function calculateYearBasedByInputValue()
    {
        return date('Y', $this->inputValue);
    }

    /**
     * @return false|int
     */
    private function calculateChristmasEveBasedByYear()
    {
        return $this->getUtcDateTimeStamp('24.12.');
    }

    /**
     * @return false|int
     */
    private function calculateNewYearsEveBasedByYear()
    {
        return $this->getUtcDateTimeStamp('31.12.');
    }

    /**
     * @return false|int
     */
    private function calculateEpiphanyBasedByYear()
    {
        return $this->getUtcDateTimeStamp('06.01.');
    }

    /**
     * @return false|int
     */
    private function calculatePresentationOfJesusAtTheTempleByYear()
    {
        return $this->getUtcDateTimeStamp('02.02.');
    }

    /**
     * @return int
     */
    private function calculateEternitySundayBasedByCristmasEve()
    {
        $days = 28;
        $differenceDays = 0;
        if (!(date('N', $this->dateChristmasEve) >= 6))
        {
            $sundayBeforeCristmasDay = strtotime('last Sunday' . self::TWO_OCLOCK_AT_NIGHT, $this->dateChristmasEve);
            $differenceDays = round(($this->dateChristmasEve - $sundayBeforeCristmasDay) / self::SECONDS_PER_DAY);
        }

        return $this->dateChristmasEve - (($days + $differenceDays) * self::SECONDS_PER_DAY);
    }

    /**
     * @return int
     */
    private function calculateEasterDateBasedByYear()
    {
        return easter_date($this->year) + 7200;
    }

    /**
     * @return float|int
     */
    private function calculatePentecostBasedByEasterDate()
    {
        return ($this->dateEaster + (49 * AbstractRules::SECONDS_PER_DAY));
    }

    private function calculatePentecostBasedByPentecost()
    {
        return ($this->datePentecost + (7 * AbstractRules::SECONDS_PER_DAY));
    }

    /**
     * @param $suffix
     * @param string $seperator
     *
     * @return string
     */
    protected function formatDate($suffix = '', $seperator = ' - ')
    {
        $date = new DateTime();
        $date->setTimestamp($this->inputValue);
        $formatter = new IntlDateFormatter('de_DE', IntlDateFormatter::SHORT, IntlDateFormatter::SHORT);
        $formatter->setPattern('EEEE, d.MM.Y');
        return ((!empty($suffix)) ? $suffix . $seperator : '') . $formatter->format($date) . $seperator . $this->DateName;
    }

    private function getUtcDateTimeStamp($date)
    {
        $dateTimezone = new \DateTimeZone('UTC');
        $dateTime = new \DateTime($date . $this->year . self::TWO_OCLOCK_AT_NIGHT, $dateTimezone);
        return $dateTime->getTimeStamp();
    }
}