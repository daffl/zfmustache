<?php

class Mustache_Application_Resource_Mustache extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * The default configuration
	 * 
	 * @var array
	 */
	static $DEFAULTS = array(
		"basePath" => "/views/scripts",
		"suffix" => "mustache",
		"enabled" => true);
	
	/**
	 * (non-PHPdoc)
	 * @see Zend_Application_Resource_Resource::init()
	 * @return Mustache_View
	 */
    public function init()
    {
    	$this->_pushAutoloader();
    	$options = $this->mergeOptions(self::$DEFAULTS, $this->getOptions());
    	extract($options); // $basePath, $suffix, $enabled
    	$view = new Mustache_View();
        $view->setBasePath($basePath);
    	if($enabled) {
	        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
    	    $viewRenderer->setView($view)->setViewSuffix($suffix);
    	}
    	return $view;
    }
    
    /**
     * 
     */
    protected function _pushAutoloader()
    {
    	$loader = Zend_Loader_Autoloader::getInstance();
    	$loader->registerNamespace('Mustache');
    	$loader->pushAutoloader(new Mustache_Application_Autoloader(), "Mustache");
    }
}