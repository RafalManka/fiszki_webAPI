<?php

class Application_Form_Westwing extends Zend_Form
{
    public function parseData ($csv_data_to_parse) {
        if (($handle = fopen($csv_data_to_parse, "r")) !== FALSE) {
            $row=0;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                if ($row >=1) {
                    $csv_data[] = array('word' => $data[0], 'translation' => $data[1]);
                }
                $row++;
            }
            fclose($handle);
            return $csv_data;
        }
    }

    public function init()
    {
        $this->setMethod('post');
        $this->setName('Import słowników');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'lanuage', array(
            'label'      => 'language long:',
            'required'   => true,
            'filters'    => array('StringTrim'),

        ));

        $this->addElement('text', 'lang_short', array(
            'label'      => 'short version of language:',
            'required'   => true,
            'filters'    => array('StringTrim'),

        ));

        $this->addElement('text', 'set_name', array(
            'label'      => 'name of set:',
            'required'   => true,
            'filters'    => array('StringTrim'),
        ));

        $element = new Zend_Form_Element_File('csv');
        $element->setLabel('Upload a *.csv data file:')
            ->setRequired(true);
        $element->addValidator('Count', false, 1);
        $element->addValidator('Size', false, 102400);
        $element->addValidator('Extension', false, 'csv');

        $this->addElements(array($element));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Upload file',
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}
