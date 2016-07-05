<?php
namespace Shopeca\XML\Generators;

use Nette;

/**
 * Class BaseItem
 * @author Martin Knor <martin.knor@gmail.com>
 * @package Shopeca\XML\Generators
 */
abstract class BaseItem extends Nette\Object implements IItem
{

	/**
	 * Validate item
	 * @return bool return true if item is valid
     */
	public function validate() {
		$reflection = $this->getReflection();

		foreach ($reflection->getProperties(\ReflectionProperty::IS_PUBLIC) as $v) {
			if ($v->getAnnotation('required')) {
				if (!isset($this->{$v->getName()})) {
					return FALSE;
				}
			}
		}

		return TRUE;
	}
}
