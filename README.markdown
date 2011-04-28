ZFMustache
============

[Mustache](http://defunkt.github.com/mustache/) views for the [Zend Framework](http://framework.zend.com/)
using the [mustache.php](https://github.com/bobthecow/mustache.php) implementation.

Installation
-----

You can clone the GIT repository directly in your library folder:

> cd myapp 

> git clone git@github.com:daffl/zfmustache.git -b zfmustache library/Mustache

Or add it as a GIT submodule to your existing repository: 

> git submodule add git@github.com:daffl/zfmustache.git -b zfmustache library/Mustache

> git submodule init


Use it
-----

The application resource will instantiate the view, set the Mustache engine autoloader
and update the view renderer (unless enabled is set to false).
Add the following to your *application.ini* to enable mustache views:

	pluginpaths.Mustache_Application_Resource = "Mustache/Application/Resource"
	resources.mustache.basePath = APPLICATION_PATH "/views/scripts" 

You can also use mustache views only in specific controllers or actions. In that case
setting the view renderer has to be disabled:

	pluginpaths.Mustache_Application_Resource = "Mustache/Application/Resource"
	resources.mustache.basePath = APPLICATION_PATH "/views/scripts"
	resources.mustache.enabled = false

After that the bootstrapped mustache view can be retrieved in any controller:

	<?php
		class IndexController extends Zend_Controller_Action
		{
			public function init()
			{
		    	$bootstrap = $this->getInvokeArg('bootstrap');
				$this->view = $bootstrap->getResource('mustache');
				$viewRenderer = $this->_helper->getHelper('viewRenderer');
				$viewRenderer->setView($this->view)->setViewSuffix('mustache');
			}

			public function indexAction()
			{
		        // action body
		        $this->view->planet = "Mars";
		        // Using a PHP 5.3 lambda function to render bold Text:
		        $engine = $this->view->getEngine();
		        $this->view->bold = function($text) use($engine) {
		        	return "<strong>" . $engine->render($text) . "</strong>";
		        };
			}
		}

A mustache file
-----

Create a file called *APPLICATION_PATH/scripts/views/index/index.mustache* e.g. like this:

	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Mustache Test</title>
		</head>
		<body>
			<h1>Hello {{planet}}!</h1>
			Hello {{#bold}}bold {{planet}}{{/bold}}
		</body>
	</html>