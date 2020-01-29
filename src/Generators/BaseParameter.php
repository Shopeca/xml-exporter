<?php
namespace Shopeca\XML\Generators;

use Nette\SmartObject;

/**
 * Class BaseParameter
 * @author Tom Hnatovsky <tom@hnatovsky.cz>
 * @package Shopeca\XML\Generators
 *
 * @property string $name
 * @property string $value
 */
abstract class BaseParameter
{

	use SmartObject;

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
