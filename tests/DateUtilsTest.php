<?php
namespace Ideaworks\Tests;

use Ideaworks\Utils\Dt as DateUtils;

/**
 *
 * @author Ulf Tiburtius <ulf@idea-works.de>
 * @since April 12, 2015
 */
class DateUtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testGetDateRangeDays()
    {
        $start = \DateTime::createFromFormat('Y-m-d', '2015-02-01', new \DateTimeZone(date_default_timezone_get()));
        $end = \DateTime::createFromFormat('Y-m-d', '2015-03-01', new \DateTimeZone(date_default_timezone_get()));
        $this->assertEquals(28, DateUtils::getDateRangeDays($start, $end));

        $start = \DateTime::createFromFormat('Y-m-d', '2012-02-01', new \DateTimeZone(date_default_timezone_get()));
        $end = \DateTime::createFromFormat('Y-m-d', '2012-03-01', new \DateTimeZone(date_default_timezone_get()));
        $this->assertEquals(29, DateUtils::getDateRangeDays($start, $end));

        $start = \DateTime::createFromFormat('Y-m-d', '2015-02-01', new \DateTimeZone(date_default_timezone_get()));
        $end = \DateTime::createFromFormat('Y-m-d', '2015-02-01', new \DateTimeZone(date_default_timezone_get()));
        $this->assertEquals(0, DateUtils::getDateRangeDays($start, $end));

        $end = \DateTime::createFromFormat('Y-m-d', '2012-02-01', new \DateTimeZone(date_default_timezone_get()));
        $start = \DateTime::createFromFormat('Y-m-d', '2012-03-01', new \DateTimeZone(date_default_timezone_get()));
        $this->assertEquals(29, DateUtils::getDateRangeDays($start, $end));
    }

    public function testCheckInDateRange()
    {
        $startDate = \DateTime::createFromFormat('Y/m/d', '2015/04/12');
        $endDate = clone $startDate;
        $checkDate = clone $startDate;

        $endDate->modify('+1 hour');
        $checkDate->modify('+10 minutes');
        $this->assertTrue(DateUtils::checkInDateRange($startDate, $endDate, $checkDate));

        $endDate->modify('-2 hour');
        $this->assertFalse(DateUtils::checkInDateRange($startDate, $endDate, $checkDate));

        // endDate and checkDate are the same date as startDate
        $endDate->modify('+1 hour');
        $checkDate->modify('-10 minutes');
        $this->assertTrue(DateUtils::checkInDateRange($startDate, $endDate, $checkDate));
    }

    public function testIntersectDateRanges()
    {
        $start1 = \DateTime::createFromFormat('Y-m-d', '2015-02-01');
        $end1 = \DateTime::createFromFormat('Y-m-d', '2015-05-01');
        $start2 = \DateTime::createFromFormat('Y-m-d', '2015-04-01');
        $end2 = \DateTime::createFromFormat('Y-m-d', '2015-06-01');
        $this->assertEquals(31, DateUtils::intersectDateRanges($start1, $end1, $start2, $end2));

        $start1 = \DateTime::createFromFormat('Y-m-d', '2015-02-01');
        $end1 = \DateTime::createFromFormat('Y-m-d', '2015-03-25');
        $start2 = \DateTime::createFromFormat('Y-m-d', '2015-03-20');
        $end2 = \DateTime::createFromFormat('Y-m-d', '2015-06-01');
        $this->assertEquals(6, DateUtils::intersectDateRanges($start1, $end1, $start2, $end2));
    }

    public function testAddMonths()
    {
        $date = \DateTime::createFromFormat('Y-m-d', '2015-01-11');
        $this->assertEquals('2016-01-11', DateUtils::addMonths($date, 12)->format('Y-m-d'));

        $date = \DateTime::createFromFormat('Y-m-d', '2015-02-28');
        $this->assertEquals('2015-03-28', DateUtils::addMonths($date, 1)->format('Y-m-d'));

        $date = \DateTime::createFromFormat('Y-m-d', '2012-02-29');
        $this->assertEquals('2015-02-28', DateUtils::addMonths($date, 36)->format('Y-m-d'));
    }

    public function testAddYears()
    {
        $date = \DateTime::createFromFormat('Y-m-d', '2015-01-11');
        $this->assertEquals('2016-01-11', DateUtils::addYears($date, 1)->format('Y-m-d'));

        $date = \DateTime::createFromFormat('Y-m-d', '2012-02-29');
        $this->assertEquals('2015-02-28', DateUtils::addYears($date, 3)->format('Y-m-d'));
    }
}
