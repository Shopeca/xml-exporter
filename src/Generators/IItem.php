<?php
namespace Shopeca\XML\Generators;

interface IItem
{
	/**
	 * @return bool Return true if item is valid
     */
	public function validate();
}
