<?php
/**
 * Zend view engine for Mustache views.
 * 
 * @see {@link http://defunkt.github.com/mustache}
 * @see {@link https://github.com/bobthecow/mustache.php}
 * 
 * @author David Luecke (daff@neyeon.de)
 */
class Mustache_View implements Zend_View_Interface
{
	/**
	 * The Mustache engine
	 * @var Feathry_View_Mustache_Engine
	 */
	protected $_mustache;
	/**
	 * The mustache view base path
	 * @var string
	 */
	protected $_path;
	/**
	 * The data in this view
	 * @var array
	 */
	protected $_data;
	
	/**
	 * Creates a new Mustache view
	 */
	public function __construct()
	{
		$this->_mustache = new Mustache();
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::getEngine()
	 */
	public function getEngine()
	{
		return $this->_mustache;
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::setScriptPath()
	 */
	public function setScriptPath($path)
	{
		$this->_path = $path;
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::getScriptPaths()
	 */
	public function getScriptPaths()
	{
		return array($this->_path);
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::setBasePath()
	 */
	public function setBasePath($path, $classPrefix = 'Zend_View')
	{
		$this->_path = $path;
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::addBasePath()
	 */
	public function addBasePath($path, $classPrefix = 'Zend_View')
	{
		$this->_path = $path;
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::__set()
	 */
	public function __set($key, $val)
	{
		$this->assign($key, $val);
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::__isset()
	 */
	public function __isset($key)
	{
		return isset($this->_data[$key]);
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::__unset()
	 */
	public function __unset($key)
	{
		unset($this->_data[$key]);
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::assign()
	 */
	public function assign($spec, $value = null)
	{
		if(is_string($spec)) {
			$this->_data[$spec] = $value;
		}
		
		if(is_array($spec)) {
			foreach($spec as $key => $val) {
				$this->assign($key, $val);
			}
		}
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::clearVars()
	 */
	public function clearVars()
	{
		$this->_data = array();
	}
	
	/* (non-PHPdoc)
	 * @see Zend_View_Interface::render()
	 */
	public function render($name)
	{
		$file = $this->_path . "/" . $name;
		if(!file_exists($file)) {
			$e = new Zend_View_Exception("Could not locate Mustache view file \"$file\"");
			$e->setView($this);
			throw $e;
		}
		$template = file_get_contents($file, true);
		return $this->_mustache->render($template, $this->_data);
	}
}