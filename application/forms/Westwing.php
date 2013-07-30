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

                /*
                 * (Un-comment) the lines with a # if
                 * you need to debbug the csv data.
                 # $num = count($data);
                 # Zend_Debug::dump($num);
                 */

                /*
                 * I'm defining the condition ($row >=1) here to skip the first line of the
                 * CSV file, which contains the header information.
                 */
                if ($row >=1) {
                    $csv_data[] = array('word' => $data[0], 'translation' => $data[1]);

//                    foreach ($csv_data as $key => $csvDataRow) {
//                        $firstname[$key] = $csvDataRow['firstname'];
//                        $lastname[$key] = $csvDataRow['lastname'];
//                    }

                    /*
                     * Order the result using php array_multisort function.
                     */
                    //array_multisort($firstname, SORT_ASC, $lastname, SORT_ASC, $csv_data);

                }
                $row++;
            }

            fclose($handle);
            //Zend_Debug::dump($csv_data);
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

        /*
         * The Following code creates an object for the file input
         * using Zend_Form_Element_File.
         */
        $element = new Zend_Form_Element_File('csv');
        $element->setLabel('Upload a *.csv data file:')
            ->setRequired(true);
        $element->addValidator('Count', false, 1);
        $element->addValidator('Size', false, 102400);
        // only *.csv extension allowed
        $element->addValidator('Extension', false, 'csv');

        // adding elements to form Object
        $this->addElements(array($element));

        /*
         * Disabled captcha code for the sake of testing purposes on this application.
         */
        /*
            // Add a captcha
            $this->addElement('captcha', 'captcha', array(
                'label'      => 'Please enter the 5 letters displayed below:',
                'required'   => true,
                'captcha'    => array(
                    'captcha' => 'Figlet',
                    'wordLen' => 5,
                    'timeout' => 300
                )
            ));
        */

        /*
	 * Submit button
	 */
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Upload file',
        ));

        /*
	 * Add some CSRF protection (Cross Site Scripting)
	 */
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }


}
