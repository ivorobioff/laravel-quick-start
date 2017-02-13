<?php
namespace ImmediateSolutions\Support\Api\Searchable\Resolvers;

use DateTime;
use ImmediateSolutions\Support\Validation\Rules\Moment;
use DateTimeZone;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DateTimeResolver
{
	/**
	 * @param string $datetime
	 * @return bool
	 */
	public function isProcessable($datetime)
	{
		return !(new Moment())->check($datetime);
	}

	/**
	 * @param string $datetime
	 * @return DateTime
	 */
	public function resolve($datetime)
	{
        $datetime = new DateTime($datetime);

        $datetime->setTimezone(new DateTimeZone('UTC'));

        return $datetime;
	}
}