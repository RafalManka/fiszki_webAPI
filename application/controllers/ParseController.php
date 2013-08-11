<?php
class ParseController extends Zend_Controller_Action
{
    public function init(){}

    public function indexAction()
    {
        $form    = new Application_Form_Westwing();
        $this->view->form = $form;
    }


    public function editAction(){


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
                        array('DynamicForm'=>$temp)
                    );

                    $this->view->parseForm = $parseForm;
                } else {
                    $this->view->errorMessage = "Error! No results to display";
                }
                $this->render('edit');
                return;
        }
    }

    public function submitAction(){

        // fetching everything from the form into variables
        $language_long = $this->getRequest()->getParam('lang_long');
        $language = $this->getRequest()->getParam('lang_short');
        $wordset_name = $this->getRequest()->getParam('name_of_set');
        $counter=0;
        $wordsInfo=array();
        while(null!==$this->getRequest()->getParam('word_'.$counter.'_original')){
            $wordsInfo[$counter]['word'] = str_replace("\"", "",
                $this->getRequest()->getParam('word_'.$counter.'_original'));
            $wordsInfo[$counter]['translation'] = str_replace("\"", "",
                $this->getRequest()->getParam('word_'.$counter.'_translation'));
            $counter++;
        }

        // fetching ID of language or if it does not exists inserting language into db and fetching its id
        // anyway you get id of language if it existed or did not
        $model = new Application_Model_DbTable_Language();
        $languageId = $model->fetchOrInsertLanguage($language, $language_long);

        $model = new Application_Model_DbTable_Wordset();
        $wordsetId = $model->fetchOrInsertWordset($wordset_name, $languageId);

        $model = new Application_Model_DbTable_Words();
        foreach($wordsInfo as $word){
            $wordId = $model->fetchOrInsertWord($word['word']);
            $translationId = $model->fetchOrInsertWord($word['translation']);

            $wht_model = new Application_Model_DbTable_Wordhastranslation();
            $wordToTranslationReltionId = $wht_model->fetchOrInsertRelation($wordId, $translationId);

            $whw_model = new Application_Model_DbTable_Wordhaswordset();
            $wordToWordsetRelationId = $whw_model->fetchOrInsertRelation($wordId, $wordsetId);


        }
    }

    public function languagesAction(){
        $file = 'csv/locale';
        $contents = file_get_contents($file);
        $rows        = explode("\n", $contents);

        $model = new Application_Model_DbTable_Language();
        foreach($rows as $row){
            $r = explode(';',$row);
            if(sizeof($r)>1)
                $model->fetchOrInsertLanguage($r[0],$r[1]);
        }
    }

}