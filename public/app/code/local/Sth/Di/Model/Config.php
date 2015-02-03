<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

class Sth_Di_Model_Config extends Mage_Core_Model_Config
{
    /**
     * @var ContainerBuilder
     */
    protected $_container;

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
    protected function _initContainer()
    {
        $this->_container = new ContainerBuilder();

        $this->_loadRootServicesXml();
        $this->_loadModulesServicesXml();
    }

    protected function _loadRootServicesXml()
    {
        $this->_loadServicesXmlForPath(
            $this->getOptions()->getEtcDir()
        );
    }

    protected function _loadModulesServicesXml()
    {
        $diNode = $this->getNode('sth_di');

        if ( ! $diNode) {
            return;
        }

        $modulesWithServices = array_keys(
            $diNode->asArray()
        );

        foreach ($modulesWithServices as $moduleName) {
            if ( ! $this->getNode('modules/' . $moduleName)->is('active')) {
                continue;
            }

            $this->_loadServicesXmlForPath(
                $this->getModuleDir('etc', $moduleName)
            );
        }
    }

    /**
     * @param string $path
     */
    protected function _loadServicesXmlForPath($path)
    {
        $loader = new XmlFileLoader(
            $this->_container,
            new FileLocator($path)
        );

        $loader->load('services.xml');
    }
}
