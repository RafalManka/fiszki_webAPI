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
                                'label' => $result['word'],
                                'value'=> $result['translation']
                            )

                        ));
                        $counter++;
                    }


                   // echo '<pre>';
                    //var_dump($temp);

                    $parseForm = new Application_Form_EditDictionary(
                        array(
                            'DynamicForm'=>$temp
                        )
                    );
                    $this->view->parsunio = $parseForm;





                } else {
                    /*
                     * This errorMessage variable was created for testing purposes.
                     * For the sake of this small application we don't have to worry
                     * about validating the contents of the csv file because we are
                     * assuming that the given file is correctly structured.
                     */
                    $this->view->errorMessage = "Error! No results to display";
                }
                //Zend_Debug::dump($this);
                $this->render('result');
                return;
        }
    }

}