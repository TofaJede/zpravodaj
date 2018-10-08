<?php
namespace Genkgo\Xsl\Xsl\Functions\IntlDateComponent;

use DateTimeInterface;
use Genkgo\Xsl\Xsl\Functions\Formatter\ComponentInterface;
use Genkgo\Xsl\Xsl\Functions\Formatter\PictureString;

/**
 * Class HourInHalfDayComponent
 * @package Genkgo\Xsl\Xsl\Functions\DateComponent
 */
final class HourInHalfDayComponent implements ComponentInterface {

    /**
     * @param PictureString $pictureString
     * @param DateTimeInterface $date
     * @return string
     */
    public function format(PictureString $pictureString, DateTimeInterface $date)
    {
        return 'hh';
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'h';
    }
}