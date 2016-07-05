<?php
namespace Shopeca\XML\Generators;

use Latte\Engine;
use Nette\Object;
use Shopeca\XML\FileEmptyException;
use Shopeca\XML\ItemIncompletedException;
use Shopeca\XML\Storage;

/**
 * Class BaseGenerator
 * @author Martin Knor <martin.knor@gmail.com>
 * @package Shopeca\XML\Generators
 */
abstract class BaseGenerator extends Object implements IGenerator {

    /** @var bool true if some products added */
    private $prepared = false;

    /** @var resource|bool|null temp file */
    private $handle;

    /** @var \Shopeca\XML\Storage */
    private $storage;

    /**
     * BaseGenerator constructor.
     * @param \Shopeca\XML\Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param $name
     * @return string path to template
     */
    abstract protected function getTemplate($name);


    /**
     * Prepare temp file
     */
    protected function prepare()
    {
        $this->handle = tmpfile();
        $this->prepareTemplate('header');
        $this->prepared = true;
    }

    /**
     * @param \Shopeca\XML\Generators\IItem $item
     * @param string $templateName
     * @throws \Exception
     * @throws \Throwable
     */
    protected function addXmlItem(IItem $item, $templateName)
    {
        if (!$this->prepared) {
            $this->prepare();
        }

        if (!$item->validate()) {
            throw new ItemIncompletedException('Item is not complete');
        }

        $latte = new Engine;
        $xmlItem = $latte->renderToString($this->getTemplate($templateName), array('item' => $item));
        fwrite($this->handle, $xmlItem);
    }

    /**
     * @param \Shopeca\XML\Generators\IItem $item
     * @throws \Exception
     * @throws \Throwable
     */
    public function addItem(IItem $item)
    {
        $this->addXmlItem($item, 'item');
    }

    /**
     * Generate file by addItem from db for example
     * @return void
     */
    abstract function generate();

    /**
     * @param $filename
     * @return void
     */
    public function save($filename)
    {
        $this->generate();

        if (!$this->prepared) {
            throw new FileEmptyException('File has not any items');
        }

        $this->prepareTemplate('footer');

        $size = ftell($this->handle);
        rewind($this->handle);
        $this->storage->save($filename, fread($this->handle, $size));

        fclose($this->handle);

        $this->prepared = false;
    }

    /**
     * @param $template
     */
    protected function prepareTemplate($template)
    {
        $file = $this->getTemplate($template);
        $footerHandle = fopen('safe://' . $file, 'r');
        $footer = fread($footerHandle, filesize($file));
        fclose($footerHandle);
        fwrite($this->handle, $footer);
    }

}