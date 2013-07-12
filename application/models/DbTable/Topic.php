<?php

class Application_Model_DbTable_Topic extends Zend_Db_Table_Abstract
{

    protected $_name = 'topic';

    public function fetchTopics($language)
    {
    	$query = $this
		->select()
		->from('topic',array(	'topic_id'		=>'topic.topic_id',
								'topic_title'	=>'topic.title'))
		->setIntegrityCheck(false)		
		->joinInner('word','topic.topic_id=word.topic_id',array(''))
		->joinInner('language','language.language_id=word.language_id',
			array(	'language_id'		=>'language_id',
					'language_title'	=>'title'))
		->group('topic.topic_id')
		->where('language.language_id = '.$language);
		/*
			SELECT `topic`.`topic_id`, `topic`.`title` AS `topic_title`, `language`.`language_id`, `language`.`title`  AS `language_title`  FROM `topic` 
			INNER JOIN `word` ON topic.topic_id=word.topic_id 
			INNER JOIN `language` ON language.language_id=word.language_id 
			WHERE (language.language_id = 1) 
			GROUP BY `topic`.`topic_id`
		*/
		$row = $this->fetchAll($query);  	
	
		if (!$row) {
    		throw new Exception("no results found");
    	}
    	return $row;
    }
}

