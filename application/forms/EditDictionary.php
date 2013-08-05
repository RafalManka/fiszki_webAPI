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
            'class'     => 'button-green submit-wordset',
            'label'    => 'OK, now submit',
        ));
    }

    public function setDynamicForm($formValues){
        foreach($formValues as $attribes){
            if($attribes['name']!='lang_long'
                && $attribes['name']!='lang_short'
                && $attribes['name']!='name_of_set')
            {
                $this
                    ->setAttrib('class','someclas')
                    ->addElement('text',
                        $attribes['name'].'_original',
                        array(
                            'label' => 'Word:',
                            'value' => $attribes['label'],
                            'class'=>'word-original search'
                        )
                    )
                ;

                $this
                    ->addElement('text',
                        $attribes['name'].'_translation',
                        array(
                            'label' => 'Translation:',
                            'value' => $attribes['value'],
                            'class'=>'word-translation search'
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
                            'class' => 'wordset-label search'
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
                'Description',
                'Errors',
                array(array('data'=>'HtmlTag'), array('tag' => 'div', 'class' => 'right')),
                array('Label', array('tag' => 'div', 'class' => 'label')),
                array(array('row'=>'HtmlTag'),array('tag'=>'div', 'class' => 'row-wrapper'))
            ));
        }

    }
}