<?php
namespace Shopeca\XML;

/**
 * Class Storage based on Shopeca\XML\Storage
 * @author Martin Knor <martin.knor@gmail.com>
 * @package Shopeca\XML
 */
class Storage implements IStorage {

    /** @var string */
    private $dir;

    /**
     * Storage constructor.
     * @param string $dir
     */
    function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * @param string $filename
     * @param string $content
     */
    public function save($filename, $content)
    {
        if(!is_dir($this->dir)) {
            mkdir($this->dir);
        }
        file_put_contents(realpath($this->dir) . DIRECTORY_SEPARATOR . $filename, $this->formatXml($content));
    }

    /**
     * @param string $xml
     * @return string
     */
    protected function formatXml($xml)
    {
        $dom = new \DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml);

        return $dom->saveXML();
    }
}
