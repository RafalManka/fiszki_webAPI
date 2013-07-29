<?php

class ImportController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {

        $language = 'sp';
        $language_long = 'Espanol';
        $wordset_name = 'idiomy #1';

        $file = new SplFileObject('csv/idioms_1.csv');
        $file->setFlags(SplFileObject::READ_CSV);

        $words='';
        $counter = 0;
        foreach ($file as $row) {
            list($word) = $row;
            $test = explode(";",$word);
            $words[$counter]['word'] = str_replace("\"", "", $test[0]);
            $words[$counter]['translation'] = str_replace("\"", "", $test[1]);
            $counter++;
        }

         $model = new Application_Model_DbTable_Language();
         $languageId = $model->fetchLanguage($language);
         if($languageId==null){
            $languageId = $model->insertLanguage($language,$language_long);
         }

         //echo 'language: '.$language_long.' (id = '.$languageId.').<br>';

         $model = new Application_Model_DbTable_Wordset();
         $wordsetId = $model->fetchWordset($wordset_name);
            if($wordsetId==null){
                $wordsetId = $model->insertWordSet($wordset_name,$languageId);
            } else {
                return;
            }

        //echo 'wordset: '.$wordset_name.' (Id = '.$wordsetId.').<br>';

        $model = new Application_Model_DbTable_Words();
        foreach($words as $word){
            //echo $word['word'].'<br>';
            $wordId = $model->fetchWord($word['word']);
            if($wordId==null){
                $wordId['word_id'] = $model->insertWord($word['word']);
            }
            //var_dump($wordId['word_id']);
            //echo 'word: '.$word['word'] .' (id = '.$wordId['word_id'].').<br>';

            $translationId = $model->fetchWord($word['translation']);
            if($translationId==null){
                $translationId['word_id'] = $model->insertWord($word['translation']);
            }
            //echo 'translation: '.$word['translation'].' (id = '.$translationId['word_id'].').<br>';

            $wht_model = new Application_Model_DbTable_Wordhastranslation();
            $reltion = $wht_model->isRelationPresent($wordId['word_id'], $translationId['word_id']);

            if($reltion==true){
                //echo 'word relation exists<br>';
            } else{
                $wht_model->saveRelation($wordId['word_id'], $translationId['word_id']);
                //echo 'word relation saved<br>';
            }


            $whw_model = new Application_Model_DbTable_Wordhaswordset();
            $reltion = $whw_model->isRelationPresent($wordId['word_id'], $wordsetId);


        }



    }


}

