<?php

class ApiController extends Zend_Controller_Action
{

    public function _initRoutes()
    {

        $front = Zend_Controller_Front::getInstance();

        $router = $front->getRouter();

        $restRoute = new Zend_Rest_Route($front);
        $router->addRoute('default', $restRoute);

    }

    public function init() {

        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
    }

    public function indexAction() {

    }

    public function getAction() {
        $wordsinfo=array();

        switch ($this->getRequest()->getParam('id')) {
            case 'fetchLanguages':
                $model = new Application_Model_DbTable_Language();
                $wordsinfo = $model->fetchLanguages();
                break;
            case 'fetchTopics':
                $model = new Application_Model_DbTable_Topic();
                $wordsinfo = $model->fetchTopics($_GET['language']);
                break;
            case 'fetchWords':


                $model = new Application_Model_DbTable_Words();
                $words = $model->fetchWords($this->getRequest()->getParam('language'),$this->getRequest()->getParam('topic'));
                $count = -1;
                $tempTitle='';

                $counter=0;
                foreach ($words as $word){
                    $wordsinfo['language_id'] = $word['language_id'];
                    $wordsinfo['locale'] = $word['locale'];
                    $wordsinfo['language'] = $word['language'];
                    $wordsinfo['wordset_id'] = $word['wordset_id'];
                    $wordsinfo['wordset'] = $word['wordset'];

                    if($tempTitle==$word['word']){
                        $counter++;
                        $wordsinfo['words'][ $count ]['translation'][ $counter ] = urldecode($word['translation']);
                    } else {
                        $tempTitle=$word['word'];
                        $counter=0;
                        $count++;
                        $wordsinfo['words'][ $count ]['word'] = urldecode($word['word']);
                        $wordsinfo['words'][ $count ]['translation'][ $counter ] = urldecode($word['translation']);

                    }
                }
                break;
            default:
                echo 'action was not specified';
                break;
        }

        echo Zend_Json::encode($wordsinfo);

    }

}







