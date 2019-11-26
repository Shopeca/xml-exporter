<?php
namespace Shopeca\XML\Generators;

/**
 * Interface IGenerator
 * @package Shopeca\XML\Generators
 */
interface IGenerator {

    /**
     * Generate file
     * @return mixed
     */
    public function generate();

    /**
     * Save file
     * @param string $filename
     * @return mixed
     */
    public function save($filename);
}
