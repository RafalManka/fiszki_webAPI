<?php

class Application_Form_Westwing extends Zend_Form
{
    /*
     * CSV Data processing
     */
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


        /* Form Elements & Other Definitions Here ... */
        $this->setMethod('post');
        $this->setName('Import słowników');
        $this->setAttrib('enctype', 'multipart/form-data');

        // Add an email element
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

        /*
         * The Following code creates an object for the file input
         * using Zend_Form_Element_File.
         */
        $element = new Zend_Form_Element_File('csv');
        $element->setLabel('plik ze słówkami w formacie *.csv (wartości odseparowane znakiem ";"):')->setRequired(true);
        $element->addValidator('Count', false, 1);
        $element->addValidator('Size', false, 102400);
        $element->setAttrib('id','button-green');


        // only *.csv extension allowed
        $element->addValidator('Extension', false, 'csv');

        // adding elements to form Object
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
