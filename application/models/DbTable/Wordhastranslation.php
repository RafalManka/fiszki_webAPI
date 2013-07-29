<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafal
 * Date: 7/29/13
 * Time: 11:01 PM
 * To change this template use File | Settings | File Templates.

 *
 **/

class Application_Model_DbTable_Wordhastranslation extends Zend_Db_Table_Abstract
{

protected $_name = 'word_has_translation';

    public function isRelationPresent($wordId, $translationId)
    {
        $query = $this->select()
            ->from(array('wht'=>'word_has_translation'))
            ->where('wht.word_id  = \''.$wordId.'\' AND wht.translation_id = \''.$translationId.'\'');

        $row = $this->fetchRow($query);
        if($row!=null){
            return true;
        } else {
            return $this->saveRelation($wordId, $translationId);

        }
    }

    public function saveRelation($wordId, $translationId)
    {
        return $this->insert( array( 'word_id'=>$wordId,'translation_id'=>$translationId ) );
    }

}