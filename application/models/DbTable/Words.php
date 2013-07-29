<?php

class Application_Model_DbTable_Words extends Zend_Db_Table_Abstract
{

    protected $_name = 'word';
	 
    
    public function fetchWords($language,$topic)
    {
    	$query = $this
		->select()
		->from(array('w' => 'word'), array(
						'word'		=>'w.value',
						'translation'	=>'t.value',
						'language'	=>'l.title',
						'wordset'	=>'ws.wordset_title'
		))
		->joinInner(array('wht' => 'word_has_translation'),	'w.word_id=wht.word_id')
		->joinInner(array('t' => 'word'),			't.word_id=wht.translation_id')
		->joinInner(array('whw' => 'word_has_wordset'),		'w.word_id=whw.word_id')
		->joinInner(array('ws' => 'wordset'),			'ws.wordset_id=whw.wordset_id')
		->joinInner(array('l' => 'language'),			'l.language_id=ws.language_id')	
		->setIntegrityCheck(false)	
		->where('l.language_id = '.$language.' AND ws.wordset_id = '.$topic);

		$row = $this->fetchAll($query);
    	
	
	if (!$row) {
    		throw new Exception("no results found");
    	}
    	return $row;
    }

    public function fetchWord($word){
        $query = $this->select()
            ->from(array('w'=>'word'), array('word_id'=>'w.word_id'))
            ->where('w.value = \''.urlencode($word).'\'');

        return $this->fetchRow($query);
    }


    public function insertWord($word){
        return $this->insert( array( 'value'=>urlencode($word) ) );
    }



   
}

