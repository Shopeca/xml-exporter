<?php
namespace Shopeca\XML\Generators;

use Nette;

/**
 * Class BaseParameter
 * @author Tom Hnatovsky <tom@hnatovsky.cz>
 * @package Shopeca\XML\Generators
 */
abstract class BaseParameter
{

	use Nette\SmartObject;

	protected $name;
	protected $value;

	/**
	 * Parameter constructor.
	 * @param string $name
	 * @param string $value
	 */
	public function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}

}
