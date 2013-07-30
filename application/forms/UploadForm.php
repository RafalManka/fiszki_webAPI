<?php
/**
 * Created by JetBrains PhpStorm.
 * User: r.manka
 * Date: 30.07.13
 * Time: 17:28
 * To change this template use File | Settings | File Templates.
 */

class Application_Form_UploadForm extends Zend_Form
{
    public function __construct($options = null)
    {
        parent::__construct($options);
        $this->setMethod('post');
        $this->setAttrib('enctype', 'multipart/form-data');

        $file = new Zend_Form_Element_File('extract');
        $file->setLabel('File')
            ->setDestination( APPLICATION_PATH . '/../public/tmp/' )
            ->addValidator('Count', false, 1)
            ->setRequired(true);

        $submit = new Zend_Form_Element_Submit('submit');
        $submit
            ->setLabel('Upload');

        $this->addElements(array($file, $submit));

    }
}