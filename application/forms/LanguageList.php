<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rafal
 * Date: 8/11/13
 * Time: 11:43 PM
 * To change this template use File | Settings | File Templates.
 */

class CustomForm extends Zend_Form

{

    public function init()

    {
        $this->setMethod('post');

        $countries = new Application_Model_DbTable_Language();
        $countries_list = $countries->getCountriesList();

        $country = new Zend_Form_Element_Select('countries');
        $country
            ->setLabel('Countries:')
            ->addMultiOptions( $countries_list );
    }
}