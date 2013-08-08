<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initRoutes()
    {

        $front = Zend_Controller_Front::getInstance();

        $router = $front->getRouter();


	  $restRoute = new Zend_Rest_Route($front, array(), array(
          'default' => array('api') ) );

	  $router->addRoute('rest', $restRoute);

    }
}
