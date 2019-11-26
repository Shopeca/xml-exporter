<?php

class TestItem extends \Shopeca\XML\Generators\BaseItem
{

	/** @var string @required */
	protected $name;

	/** @var string */
	protected $text;

	public function __construct($name = null, $text = null)
	{
		if ($name !== null) {
			$this->name = $name;
		}
		if ($text !== null) {
			$this->text = $text;
		}
	}

}
