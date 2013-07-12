<?php

class Application_Model_DbTable_Language extends Zend_Db_Table_Abstract
{

    protected $_name = 'language';

    public function fetchLanguages()
    {
    	$query = $this
		->select()
		->from('language',array(	'language_id'		=>'language.language_id',
								'language_title'	=>'language.title'))
		;

		$row = $this->fetchAll($query);  	
	
		if (!$row) {
    		throw new Exception("no results found");
    	}
    	return $row;
    }
}

