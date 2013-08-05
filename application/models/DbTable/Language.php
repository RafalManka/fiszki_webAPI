<?php

class Application_Model_DbTable_Language extends Zend_Db_Table_Abstract
{

    protected $_name = 'language';

    public function fetchLanguages()
    {
    	$query = $this
		->select()
		->from('language',array(	
				'language_id' => 'language.language_id',
				'language_title' => 'language.title',
				'title_long' => 'language.title_long'));

		$row = $this->fetchAll($query);  	
	
		if (!$row) {
    		throw new Exception("no results found");
    	}
    	return $row;
    }

    public function fetchOrInsertLanguage($language, $language_long){

	     $query = $this
		->select()
		->from(array('l' => 'language'), array(
						'language_id'		=>'l.language_id',
						'language'	=>'l.title'
		))
		->where('l.title = \''.$language."'");

		$row = $this->fetchRow($query);

        if(!$row){
            return $this->insertLanguage($language, $language_long);
        } else {
            return $row['language_id'];
        }
    }

    private function insertLanguage($language, $language_long){
    	return $this->insert( array('title'=>$language,'title_long'=>$language_long) );
    }
}

