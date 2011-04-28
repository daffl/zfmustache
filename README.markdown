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
Add the following lines to your *application.ini* to enable mustache views:

	pluginpaths.Mustache_Application_Resource = "Mustache/Application/Resource"
	resources.mustache.basePath = APPLICATION_PATH "/views/scripts" 

You can also use mustache views only in specific controllers or actions. For example
(using *APPLICATION_PATH/views/scripts/controllername/actionname.mustache* as the template):

	pluginpaths.Mustache_Application_Resource = "Mustache/Application/Resource"
	resources.mustache.basePath = APPLICATION_PATH "/views/scripts"
	resources.mustache.enabled = false

The following can be used in any controller:

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
				$this->view->planet = "Mars";
			}
		}

A mustache file
-----

Create a file called *APPLICATION_PATH/views/index/scripts/index.mustache* e.g. like this:

	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
	<html>
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
			<title>Mustache Test</title>
		</head>
		<body>
			<h2>Hello {{planet}}!</h2>
		</body>
	</html>