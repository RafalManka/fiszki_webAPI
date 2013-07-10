<?php

class ApiController extends Zend_Controller_Action
{

    public function init()
    {

        $this->_helper->viewRenderer->setNoRender(true);

        $this->_todo = array (
          "de" => array(
                "Dzień"=>"Tag",
                "Dobry"=>"Gut",
                "Do widzenia"=>"Aufviedersehen"
                ),
          "en" => array(
                "Dzień"=>"Day",
                "Dobry"=>"Good",
                "Do widzenia"=>"Good bye"
                ),
          "ita" => array(
                "Dzień"=>"El sol",
                "Dobry"=>"bueno",
                "Do widzenia"=>"muchos gracias"
                ),
        );

    }

    public function indexAction()
    {
       echo Zend_Json::encode($this->_todo);
    }

    public function getAction()
    {
       
       $id =  $_GET['lang']; 
       echo Zend_Json::encode($this->_todo[$id]);
    }

    public function postAction()
    {
        // action body
    }

    public function putAction()
    {
        // action body
    }

    public function deleteAction()
    {
        // action body
    }


}









