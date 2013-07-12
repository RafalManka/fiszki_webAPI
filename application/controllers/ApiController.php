<?php

class ApiController extends Zend_Controller_Action
{

    public function init() {
	
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {
       
    }
 	
    public function getAction() {   

        switch ($this->getRequest()->getParam('id')) {
            case 'fetchLanguages':
                $model = new Application_Model_DbTable_Language();
                $words = $model->fetchLanguages();
                break;
            case 'fetchTopics':
                $model = new Application_Model_DbTable_Topic();
                $words = $model->fetchTopics($_GET['language']);
                break;
            case 'fetchWords':
             $model = new Application_Model_DbTable_Words();
                $words = $model->fetchWords($_GET['language'],$_GET['topic']);
                break;
            default:
                echo 'action was not specified';
                break;
        }

    	echo Zend_Json::encode($words);
    

}

}







