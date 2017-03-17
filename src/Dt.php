<?php
namespace lftbrts\Utils;

/**
 *
 * @author Ulf Tiburtius <ulf@idea-works.de>
 * @since April 12, 2015
 */
class Dt
{
    /**
     * Retrieve the days between two dates.
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     *
     * @return number
     */
    public static function getDateRangeDays(\DateTime $startDate, \DateTime $endDate)
    {
        $tz1 = $startDate->getTimezone();
        $tz2 = $endDate->getTimezone();
        $startDate->setTimezone(new \DateTimeZone('UTC'));
        $endDate->setTimezone(new \DateTimeZone('UTC'));

        $result = $startDate->diff($endDate, false);
        $startDate->setTimezone($tz1);
        $endDate->setTimezone($tz2);

        return $result->days;
    }

    /**
     * Check if a date is within two dates (total days).
     *
     * @param \DateTime $startDate
     * @param \DateTime $endDate
     * @param \DateTime $checkDate
     *
     * @return boolean
     */
    public static function checkInDateRange(\DateTime $startDate, \DateTime $endDate, \DateTime $checkDate)
    {
        $startts = $startDate->getTimestamp();
        $endts = $endDate->getTimestamp();
        $checkts = $checkDate->getTimestamp();
        return ($checkts >= $startts && $checkts <= $endts);
    }

    /**
     * Determine if two date-ranges intersects.
     * If so, the total days between the dates will be returned.
     *
     * @param string $startDate1
     * @param string $endDate1
     * @param string $startDate2
     * @param string $endDate2
     *
     * @return boolean|number If the ranges intersects, a number of days (total) is returned. Otherwise FALSE is returned.
     */
    public static function intersectDateRanges($startDate1, $endDate1, $startDate2, $endDate2)
    {
        $start1ts = $startDate1->getTimestamp();
        $end1ts = $endDate1->getTimestamp();
        $start2ts = $startDate2->getTimestamp();
        $end2ts = $endDate2->getTimestamp();
        $intersects = ($start1ts == $start2ts) || ($start1ts > $start2ts ? $start1ts <= $end2ts : $start2ts <= $end1ts);
        if ($intersects) {
            $overlap = (min($end1ts, $end2ts) - max($start1ts, $start2ts)) + 86400;
            return ($overlap < 0 ? false : (integer) floor(($overlap / 86400)));
        }
        return false;
    }

    /**
     * Makes sure that adding months always ends up in the month you would expect.
     * Works for positive and negative values.
     *
     * @param \DateTime $date
     * @param integer $months
     *
     * @return \DateTime
     */
    public static function addMonths(\DateTime $date, $months)
    {
        $init = clone $date;
        $months = (integer)$months;
        $modifier = $months . ' months';
        $back_modifier = - $months . ' months';

        $date->modify($modifier);
        $back_to_init = clone $date;
        $back_to_init->modify($back_modifier);

        while ($init->format('m') !== $back_to_init->format('m')) {
            $date->modify('-1 day');
            $back_to_init = clone $date;
            $back_to_init->modify($back_modifier);
        }
        return $date;
    }

    /**
     * Makes sure that adding years always ends up in the month you would expect.
     * Works for positive and negative values.
     *
     * @param \DateTime $date
     * @param integer $years
     *
     * @return \DateTime
     */
    public static function addYears(\DateTime $date, $years)
    {
        $init = clone $date;
        $modifier = (integer) $years . ' years';
        $date->modify($modifier);

        while ($date->format('m') !== $init->format('m')) {
            $date->modify('-1 day');
        }

        return $date;
    }

}
