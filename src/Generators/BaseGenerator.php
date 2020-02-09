<?php
namespace Shopeca\XML\Generators;

use Latte\Engine;
use Nette\SmartObject;
use Shopeca\XML\FileEmptyException;
use Shopeca\XML\ItemIncompletedException;
use Shopeca\XML\Storage;

/**
 * Class BaseGenerator
 * @author Martin Knor <martin.knor@gmail.com>
 * @package Shopeca\XML\Generators
 */
abstract class BaseGenerator implements IGenerator {

	use SmartObject;

    /** @var bool true if some products added */
	protected $prepared = false;

    /** @var resource|bool */
    protected $handle;

    /** @var \Shopeca\XML\Storage */
	protected $storage;

    /**
     * BaseGenerator constructor.
     * @param \Shopeca\XML\Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * @param string $name
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
        if (is_resource($this->handle)) {
            fwrite($this->handle, $xmlItem);
        }
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
     * @param string $filename
     * @return void
     */
    public function save($filename)
    {
        $this->generate();

        if (!$this->prepared) {
            throw new FileEmptyException('File has not any items');
        }

        $this->prepareTemplate('footer');

        if (is_resource($this->handle)) {
            $size = ftell($this->handle) ?: 0;
            rewind($this->handle);
            $this->storage->save($filename, fread($this->handle, $size) ?: '');

            fclose($this->handle);
        }

        $this->prepared = false;
    }

    /**
     * @param string $template
     */
    protected function prepareTemplate($template)
    {
        $file = $this->getTemplate($template);
        $footerHandle = fopen('safe://' . $file, 'r');
        if (is_resource($footerHandle)) {
        	$size = filesize($file) ?: 0;
            $footer = fread($footerHandle, $size);
            fclose($footerHandle);
            if ($footer && is_resource($this->handle)) {
                fwrite($this->handle, $footer);
            }
        }
    }

}
