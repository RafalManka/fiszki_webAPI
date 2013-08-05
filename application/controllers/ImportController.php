<?php

class ImportController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

        echo 'hello there!';

    }

    public function saveAction()
    {

<<<<<<< HEAD


=======
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
            $wordToTranslationReltionId = $wht_model->fetchOrInsertRelation($wordId['word_id'], $translationId['word_id']);

            $whw_model = new Application_Model_DbTable_Wordhaswordset();
            $wordToWordsetRelationId = $whw_model->fetchOrInsertRelation($wordId, $wordsetId);

            echo '<pre>';
            var_dump('$languageId: '.$languageId.' $wordsetId: '
            .$wordsetId.' $wordId: '.$wordId.' $translationId: '
            .$translationId.' $wordToTranslationReltionId: '.$wordToTranslationReltionId
            .' $wordToWordsetRelationId: '.$wordToWordsetRelationId);
        }
>>>>>>> e181c906a8ad4a61949dbb7bde4c3afb9dbdb44d
    }
}

