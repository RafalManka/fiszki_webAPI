<?php

class Application_Model_DbTable_Wordset extends Zend_Db_Table_Abstract
{

    protected $_name = 'wordset';
	 

	 public function fetchWordset($wordset){
	 	$query = $this
		->select()
		->from(array('w' => 'wordset'), array(
						'wordset_title'	=> 'w.wordset_title',
						'wordset_id'	=> 'w.wordset_id',
						'language_id' 	=> 'w.language_id'
					))
		->where('w.wordset_title = \''.$wordset."'");

         $row = $this->fetchRow($query);

         return $row['wordset_id'];
	 }
    
    public function insertWordset($wordset_name, $language_id)
    {


        return $this->insert( array('wordset_title'=>$wordset_name,'language_id'=>$language_id) );

    }

   
}

