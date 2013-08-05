<?php

class Application_Form_Westwing extends Zend_Form
{
    public function parseData ($csv_data_to_parse) {
        if (($handle = fopen($csv_data_to_parse, "r")) !== FALSE) {
            $row=0;
            while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
<<<<<<< HEAD

                    if ($row >1 && sizeof($data )> 1) {
                        $csv_data[] = array('word' => $data[0], 'translation' => $data[1]);
                    }
                    $row++;


=======
                if ($row >=1) {
                    $csv_data[] = array('word' => $data[0], 'translation' => $data[1]);
                }
                $row++;
>>>>>>> e181c906a8ad4a61949dbb7bde4c3afb9dbdb44d
            }
            fclose($handle);
<<<<<<< HEAD
            //var_dump($csv_data);die;
=======
>>>>>>> e181c906a8ad4a61949dbb7bde4c3afb9dbdb44d
            return $csv_data;
        }
    }

    public function init()
    {
        $this->setMethod('post');
        $this->setName('Import słowników');
        $this->setAttrib('enctype', 'multipart/form-data');

        $this->addElement('text', 'lanuage', array(
            'label'      => 'Pełna nazwa języka:',
            'required'   => true,
            'class'      => 'search',
            'filters'    => array('StringTrim'),

        ));

        $this->addElement('text', 'lang_short', array(
            'label'      => 'Skrótowa nazwa języka:',
            'required'   => true,
            'class'      => 'search',
            'filters'    => array('StringTrim'),

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
<<<<<<< HEAD
        $element->setAttrib('id','button-green');


        // only *.csv extension allowed
=======
>>>>>>> e181c906a8ad4a61949dbb7bde4c3afb9dbdb44d
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
