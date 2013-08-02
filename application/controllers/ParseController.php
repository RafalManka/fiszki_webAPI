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
            $language = $this->getRequest()->getParam('lanuage');
            $lang_short = $this->getRequest()->getParam('lang_short');
            $set_name = $this->getRequest()->getParam('set_name');

                $result_array = $form->parseData($_FILES["csv"]["tmp_name"]);
                if ($result_array) {
                    $this->view->results = $result_array;
                    $temp = array(
                        array('name'=>'lang_long','label'=>'Language:','value'=>$language),
                        array('name'=>'lang_short','label'=>'Languiage abbreviation:','value'=>$lang_short),
                        array('name'=>'name_of_set','label'=>'name of Your set:','value'=>$set_name),
                    );
                    $counter=0;
                    foreach($result_array as $result){
                        $temp = array_merge((array)$temp, array(
                            array(
                                'name'=>'word_'.$counter,
                                'label' => iconv(mb_detect_encoding($result['word']), 'UTF-8', $result['word']),
                                'value'=> iconv(mb_detect_encoding($result['translation']), 'UTF-8', $result['translation']),
                            )
                        ));
                        $counter++;
                    }
                    $parseForm = new Application_Form_EditDictionary(
                        array(
                            'DynamicForm'=>$temp
                        )
                    );
                    $this->view->parsunio = $parseForm;
                } else {
                    $this->view->errorMessage = "Error! No results to display";
                }
                $this->render('result');
                return;
        }
    }

}