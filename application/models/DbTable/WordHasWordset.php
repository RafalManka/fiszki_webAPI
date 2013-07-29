<?php


class Application_Model_DbTable_Wordhaswordset extends Zend_Db_Table_Abstract
{

    protected $_name = 'word_has_translation';

    public function isRelationPresent($wordId, $translationId){
        $query = $this->select()
            ->from(array('wht'=>'word_has_translation'))
            ->where('wht.word_id  = \''.$wordId.'\' AND wht.translation_id = \''.$translationId.'\'');

        $row = $this->fetchRow($query);
        if($row!=null){
            return true;
        } else {
            return false;
        }
    }

    public function saveRelation($wordId, $translationId){}


    }