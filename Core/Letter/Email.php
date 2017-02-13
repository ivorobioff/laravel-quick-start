<?php
namespace ImmediateSolutions\Support\Core\Letter;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class Email
{
	/**
	 * @var Contact[]
	 */
	private $recipients = [];

	/**
	 * @var Contact
	 */
	private $sender;

	/**
	 * @param string $email
	 * @param string $name
	 * @return $this
	 */
	public function addRecipient($email, $name = null)
	{
		$this->recipients[] = new Contact($email, $name);
		return $this;
	}

	/**
	 * @return Contact[]
	 */
	public function getRecipients()
	{
		return $this->recipients;
	}

	/**
	 * @param $email
	 * @param string $name
	 * @return $this
	 */
	public function setSender($email, $name = null)
	{
		$this->sender = new Contact($email, $name);
		return $this;
	}

	/**
	 * @return Contact
	 */
	public function getSender()
	{
		return $this->sender;
	}
}