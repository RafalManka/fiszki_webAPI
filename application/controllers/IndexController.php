<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $forma = new Application_Form_UploadForm();
        $this->view->form = $forma;

        $req = $this->getRequest();
        if($this->getRequest()->isPost())
        {
            if($forma->isValid($req->getPost()))
            {
                if(!$forma->extract->receive())
                {
                    $this->view->msg = 'upload error';
                } else {
                    $this->redirect('/import');
                }


            }
        }

    }


}

