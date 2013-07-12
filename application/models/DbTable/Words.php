<?php

class Application_Model_DbTable_Words extends Zend_Db_Table_Abstract
{

    protected $_name = 'word';
	 
    
    public function fetchWords($language,$topic)
    {
    	$query = $this
		->select()
		->from('word')
		->setIntegrityCheck(false)
		->joinInner('language','language.language_id=word.language_id')
		->joinInner('topic','topic.topic_id=word.topic_id')
		->where('word.language_id = '.$language.' AND word.topic_id = '.$topic);
	


		$row = $this->fetchAll($query);
    	
	
	if (!$row) {
    		throw new Exception("no results found");
    	}
    	return $row;
    }

   
}

