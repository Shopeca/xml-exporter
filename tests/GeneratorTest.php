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

}
