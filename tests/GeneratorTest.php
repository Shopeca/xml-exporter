<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class GeneratorTest extends TestCase
{

	public function testXml(): void
	{
		require_once __DIR__ . '/TestItem.php';

		$testItem = new TestItem();
		$this->assertFalse($testItem->validate());

		$testItem = new TestItem(null, 'Text');
		$this->assertFalse($testItem->validate());

		$testItem = new TestItem('Name', 'Text');
		$this->assertTrue($testItem->validate());
	}

	public function testBaseParameter(): void
	{
		$stub = $this->getMockForAbstractClass('\Shopeca\XML\Generators\BaseParameter', ['barva', 'red']);

		assert($stub, \Shopeca\XML\Generators\BaseParameter::class);

		$this->assertSame('barva', $stub->name);
		$this->assertSame('red', $stub->value);

		$this->assertSame('barva', $stub->getName());
		$this->assertSame('red', $stub->getValue());
	}

}
