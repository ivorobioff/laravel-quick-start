<?php
namespace ImmediateSolutions\Support\Core\Criteria;

use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Day
{
	/**
	 * @var DateTime
	 */
	private $datetime;

	/**
	 * @param string|DateTime $source
	 */
	public function __construct($source)
	{
		if ($source instanceof DateTime){
			$this->datetime = $source;
		} else {
			$this->datetime = new DateTime($source);
		}
	}

	/**
	 * @return DateTime
	 */
	public function startsAt()
	{
		return new DateTime($this->datetime->format('Y-m-d 00:00:00'));
	}

	/**
	 * @return DateTime
	 */
	public function endsAt()
	{
		return new DateTime($this->datetime->format('Y-m-d 23:59:59'));
	}
}