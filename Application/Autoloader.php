<?php
/**
 * Implements a global autoloader for loading the Mustache and MustacheException class,
 * so that the original engine files don't need to be modified.
 * 
 * @author David Luecke (daff@neyeon.de)
 */
class Mustache_Application_Autoloader implements Zend_Loader_Autoloader_Interface
{
    public function autoload($class)
    {
    	if($class == 'Mustache' || $class == 'MustacheException') {
    		require_once 'Mustache/Engine.php';
    	}
    }
}