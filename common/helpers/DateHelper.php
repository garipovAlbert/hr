<?php

namespace common\helpers;

use DateTime;
use DateTimeZone;
use IntlDateFormatter;
use Yii;
use yii\helpers\FormatConverter;

/**
 * Description of DateHelper
 *
 * @author Albert Garipov <bert320@gmail.com>
 */
class DateHelper
{

    const SQL_DATE_FORMAT = 'Y-m-d';
    const SQL_DATETIME_FORMAT = 'Y-m-d H:i:s';

    private static $_dateFormats = [
        'short' => 3, // IntlDateFormatter::SHORT,
        'medium' => 2, // IntlDateFormatter::MEDIUM,
        'long' => 1, // IntlDateFormatter::LONG,
        'full' => 0, // IntlDateFormatter::FULL,
    ];

    /**
     * Parses date string into UNIX timestamp.
     * @param string $value string representing date
     * @return boolean|integer UNIX timestamp or false on failure
     */
    public static function parseDateValue($value, $format)
    {
        $f = Yii::$app->formatter;

        if (is_array($value)) {
            return false;
        }

        if (strncmp($format, 'php:', 4) === 0) {
            $format = substr($format, 4);
        } else {
            if (extension_loaded('intl')) {
                if (isset(static::$_dateFormats[$format])) {
                    $formatter = new IntlDateFormatter($f->locale, static::$_dateFormats[$format], IntlDateFormatter::NONE, $f->timeZone);
                } else {
                    $formatter = new IntlDateFormatter($f->locale, IntlDateFormatter::NONE, IntlDateFormatter::NONE, $f->timeZone, null, $format);
                }
                // enable strict parsing to avoid getting invalid date values
                $formatter->setLenient(false);
                return $formatter->parse($value);
            } else {
                // fallback to PHP if intl is not installed
                $format = FormatConverter::convertDateIcuToPhp($format, 'date');
            }
        }
        $date = DateTime::createFromFormat($format, $value, new DateTimeZone($f->timeZone));
        $errors = DateTime::getLastErrors();
        if ($date === false || $errors['error_count'] || $errors['warning_count']) {
            return false;
        } else {
            // if no time was provided in the format string set time to 0 to get a simple date timestamp
            if (strpbrk($format, 'HhGgis') === false) {
                $date->setTime(0, 0, 0);
            }
            return $date->getTimestamp();
        }
    }

}