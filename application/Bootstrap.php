<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    public function _initRoutes()
    {

        $front = Zend_Controller_Front::getInstance();

        $router = $front->getRouter();

<<<<<<< HEAD
        $restRoute = new Zend_Rest_Route($front, array(), array(
            'default' => array('api') ) );
=======
	  $restRoute = new Zend_Rest_Route($front, array(), array(
          'default' => array('api') ) );

	  $router->addRoute('rest', $restRoute);
>>>>>>> e181c906a8ad4a61949dbb7bde4c3afb9dbdb44d

        $router->addRoute('rest', $restRoute);

    }
}
