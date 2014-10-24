<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Sth_Di_Model_Config extends Mage_Core_Model_Config
{
    /**
     * @var ContainerBuilder
     */
    private $_container;

    /**
     * Class construct
     *
     * @param mixed $sourceData
     */
    public function __construct($sourceData = null)
    {
        parent::__construct($sourceData);
    }

    /**
     * Gets an object from the DI Container
     *
     * @param string $reference
     * @return mixed
     */
    public function getFromContainer($reference)
    {
        if (null === $this->_container) {
            $this->_initContainer();
        }

        return $this->_container->get($reference, ContainerBuilder::NULL_ON_INVALID_REFERENCE);
    }

    /**
     * Initialises the DI container
     */
    private function _initContainer()
    {
        $this->_container = new ContainerBuilder();
        $loader = new XmlFileLoader($this->_container, new FileLocator($this->getOptions()->getEtcDir()));
        $loader->load('services.xml');
    }
}