<?php

class Application_Form_Westwing extends Zend_Form
{
    public function parseData ($csv_data_to_parse) {
        if (($handle = fopen($csv_data_to_parse, "r")) !== FALSE) {
            $row=0;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {


                    if ($row >1 && sizeof($data )> 1) {
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

/*        $this->addElement('text', 'lanuage', array(
            'label'      => 'Pełna nazwa języka:',
            'required'   => true,
            'class'      => 'search',
            'filters'    => array('StringTrim'),

        ));*/

        $countries = new Application_Model_DbTable_Language();
        $countries_list = $countries->getCountriesList();
        $this->addElement('select', 'lang_short', array(
            'label'      => 'Język:',
            'required'   => true,
            'class'      => 'search',
            'filters'    => array('StringTrim'),
            'multiOptions' => $countries_list
        ));

        $this->addElement('text', 'set_name', array(
            'label'      => 'Nazwa zestawu słówek:',
            'required'   => true,
            'class'      => 'search',
            'filters'    => array('StringTrim'),
        ));

        $element = new Zend_Form_Element_File('csv');
        $element->setLabel('plik ze słówkami w formacie *.csv (wartości odseparowane znakiem ";"):')->setRequired(true);
        $element->addValidator('Count', false, 1);
        $element->addValidator('Size', false, 102400);
        $element->setAttrib('id','button-green');


        // only *.csv extension allowed

        $element->addValidator('Extension', false, 'csv');

        $this->addElements(array($element));

        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Importuj plik',
            'class'      => 'button-green'
        ));

        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}
