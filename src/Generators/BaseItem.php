<?php
namespace Shopeca\XML\Generators;

use Nette;

abstract class BaseItem implements IItem
{

	use Nette\SmartObject;

	private $validationFails = [];

	/**
	 * Validate item
	 * @return bool return true if item is valid
     */
	public function validate() {
		$valid = true;
		$this->validationFails = [];

		try {
			$reflection = new \ReflectionClass($this);

			foreach ($reflection->getProperties(\ReflectionProperty::IS_PROTECTED) as $v) {
				$comment = $v->getDocComment();
				if ($comment && preg_match('|\@required|', $comment)) {
					if (!isset($this->{$v->getName()})) {
						$this->validationFails[] = $v->getName();
						$valid = false;
					}
				}
			}
		} catch (\Exception $exception) {
			return $valid;
		}

		return $valid;
	}

	public function getLastValidationErrors()
	{
		return $this->validationFails;
	}

}
