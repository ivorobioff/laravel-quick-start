<?php
namespace ImmediateSolutions\Support\Validation\Rules;

use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Greater extends Compare
{
    /**
     * @param int|float|DateTime $value
     * @param int|float|DateTime $scope
     * @return bool
     */
    public function compare($value, $scope)
    {
        return $value > $scope;
    }

    /**
     * @return string
     */
    protected function getDirection()
    {
        return 'greater';
    }
}