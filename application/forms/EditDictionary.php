<?php
/**
 * Created by JetBrains PhpStorm.
 * User: r.manka
 * Date: 01.08.13
 * Time: 18:27
 * To change this template use File | Settings | File Templates.
 */

class Application_Form_EditDictionary extends Zend_Form {

    public function init(){

        $this->setMethod('post');
        $this->setAction('import/save');

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore'   => true,
            'label'    => 'Sign Guestbook',
        ));
    }

    public function setDynamicForm($formValues){
        foreach($formValues as $attribes){

            if($attribes['name']!='lang_long'
                && $attribes['name']!='lang_short'
                && $attribes['name']!='name_of_set')
            {
                $this
                    ->addElement('text',
                        $attribes['name'].'_original',
                        array(
                            'label' => 'słowo: ',
                            'value' => $attribes['label'],
                            'class'=>'word-original'
                        )
                    )
                ;

                $this
                    ->addElement('text',
                        $attribes['name'].'_translation',
                        array(
                            'label' => 'tłumaczenie: ',
                            'value' => $attribes['value'],
                            'class'=>'word-translation'
                        )
                    )
                ;
            } else {
                $this
                    ->addElement('text',
                        $attribes['name'],
                        array(
                            'label' => $attribes['label'],
                            'value' => $attribes['value'],
                            'class' => 'wordset-descriptiopn'
                        )

                    )
                ;
            }



        }

        $elements = $this->getElements();
        foreach ($elements as $elem){
            $elem->removeDecorator('HtmlTag');
            $elem->setDecorators(array(
                'ViewHelper',
                array(array('data'=>'HtmlTag'), array('tag' => 'td')),
                array('Label', array('tag' => 'td')),
                array(array('row'=>'HtmlTag'),array('tag'=>'tr'))
            ));
        }

    }
}