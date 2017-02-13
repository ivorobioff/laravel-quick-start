<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Less extends Compare
{
    /**
     * @param int|float|DateTime $value
     * @param int|float|DateTime $scope
     * @return bool
     */
    protected function compare($value, $scope)
    {
        return $value < $scope;
    }

    /**
     * @return string
     */
    protected function getDirection()
    {
        return 'less';
    }
}