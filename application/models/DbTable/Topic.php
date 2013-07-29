<?php

class Application_Model_DbTable_Topic extends Zend_Db_Table_Abstract
{

    protected $_name = 'wordset';

    public function fetchTopics($language)
    {
    	$query = $this
		->select()
		->from('wordset',array(	'topic_id'		=>'wordset.wordset_id',
								'topic_title'	=>'wordset.wordset_title'))


		->joinInner('word_has_wordset','word_has_wordset.wordset_id=wordset.wordset_id',array(''))	
		->joinInner('word','word_has_wordset.word_id=word.word_id',array(''))
		->joinInner('language','language.language_id=wordset.language_id',
			array(	'language_id'		=>'language_id',
					'language_title'	=>'title'))
		->setIntegrityCheck(false)
		->group('wordset.wordset_id')
		->where('language.language_id = '.$language);


		$row = $this->fetchAll($query);  	
	
		if (!$row) {
    		throw new Exception("no results found");
    	}
    	return $row;
    }
}

