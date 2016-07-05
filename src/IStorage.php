<?php
namespace Shopeca\XML;

interface IStorage
{
	public function __construct($dir);
	public function save($fileName, $content);
}
