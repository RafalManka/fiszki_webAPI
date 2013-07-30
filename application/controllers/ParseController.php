<?php
class ParseController extends Zend_Controller_Action
{
    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $form    = new Application_Form_Westwing();
        $this->view->form = $form;

    }

    public function postAction(){

        $form    = new Application_Form_Westwing();
        if ($this->getRequest()->isPost()) {

                $this->view->lanuage = $this->getRequest()->getParam('lanuage');
            $this->view->lang_short = $this->getRequest()->getParam('lang_short');
            $this->view->set_name = $this->getRequest()->getParam('set_name');
                $result_array = $form->parseData($_FILES["csv"]["tmp_name"]);


                if ($result_array) {
                    $this->view->results = $result_array;
                }
                else {
                    /*
                     * This errorMessage variable was created for testing purposes.
                     * For the sake of this small application we don't have to worry
                     * about validating the contents of the csv file because we are
                     * assuming that the given file is correctly structured.
                     */
                    $this->view->errorMessage = "Error! No results to display";
                }
                Zend_Debug::dump($this);
                $this->render('result');
                return;

        }
    }

}