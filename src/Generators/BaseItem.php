<?php
namespace Shopeca\XML\Generators;

use Nette;

abstract class BaseItem implements IItem
{

	use Nette\SmartObject;

	/**
	 * Validate item
	 * @return bool return true if item is valid
     */
	public function validate() {

		try {
			$reflection = new \ReflectionClass($this);

			foreach ($reflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $v) {
				$comment = $v->getDocComment();
				if ($comment && preg_match('|\@required|', $comment)) {
					if (!isset($this->{$v->getName()})) {
						return false;
					}
				}
			}
		} catch (\Exception $exception) {
			return true;
		}

		return true;
	}

}
