<?php

namespace App\Tests\Util;

use App\Util\DateTime;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Stopwatch\Stopwatch;

class DateTimeTest extends TestCase
{
    public function testGetDateTimeStringMethodsReturnsWithProvidedFormat()
    {
        $date   = '2018-10-10 10:00:00';
        $format = 'Y-m-d';

        $actualResult   = DateTime::getDateTimeString($date, $format);
        $expectedResult = '2018-10-10';

        $this->assertSame($actualResult, $expectedResult);
    }

    public function testGetDateTimeStringMethodsReturnsWithProvidedDate()
    {
        $date = '2018-10-10 10:00:00';

        $actualResult   = DateTime::getDateTimeString($date);
        $expectedResult = '2018-10-10 10:00:00';

        $this->assertSame($actualResult, $expectedResult);
    }

    public function testGetDateTimeStringMethodsReturnsCurrentDateTime()
    {
        $stopwatch = new Stopwatch();
        $now       = new \DateTime('now');

        $stopwatch->start('clock1');
        sleep(2);

        $now->modify('+2 second');

        $actualResult   = DateTime::getDateTimeString();
        $expectedResult = $now->format(DateTime::FORMAT_DEFAULT);
        $stopwatch->stop('clock1');

        $this->assertSame($actualResult, $expectedResult);
    }

    public function testGetDateTimeMethodsReturnsCurrentDateTime()
    {
        $stopwatch = new Stopwatch();
        $now       = new \DateTime('now');

        $stopwatch->start('clock2');
        sleep(2);

        $now->modify('+2 second');

        $actualResult   = DateTime::getDateTime();
        $expectedResult = $now;

        $stopwatch->stop('clock2');

        $this->assertSame(
            $actualResult->format(DateTime::FORMAT_DEFAULT),
            $expectedResult->format(DateTime::FORMAT_DEFAULT)
        );
    }
}
