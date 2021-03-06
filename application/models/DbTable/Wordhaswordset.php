<?php


class Application_Model_DbTable_Wordhaswordset extends Zend_Db_Table_Abstract
{

    protected $_name = 'word_has_wordset';

    public function fetchOrInsertRelation($wordId, $wordsetId)
    {
        $query = $this
            ->select()
            ->from(array('whw'=>'word_has_wordset'))
            ->where('whw.word_id  = \''.$wordId.'\' AND whw.wordset_id = \''.$wordsetId.'\'');


        $row = $this->fetchRow($query);

        if($row!=null){

            return $row['id'];
        } else {
            return $this->saveRelation($wordId, $wordsetId);
        }
    }

    public function saveRelation($wordId, $wordsetId)
    {
        return $this->insert( array( 'word_id'=>$wordId,'wordset_id'=>$wordsetId ) );
    }

}