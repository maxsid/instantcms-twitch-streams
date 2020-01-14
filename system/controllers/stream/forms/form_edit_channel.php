<?php

class formStreamEditChannel extends cmsForm {

    public function init() {
        return array(
            array(
                'type' => 'fieldset',
                'childs' => array(
                    new fieldString('title', array(
                        'title' => LANG_STREAM_TITLE,
                        'rules' => array(
                            array('required'),
                            array('min_length', 5),
                            array('max_length', 50)
                        )
                            )),
                    new fieldImage('logo', array(
                        'title' => LANG_STREAM_LOGO,
                        'hint' => LANG_STREAM_RECOMMENDED_RATIO,
                        'rules' => array(
                            array('required')),
                        'options' => array(
                            'sizes' => array('small','original')
                    ))),
                    new fieldHtml('description', array(
                        'title' => LANG_STREAM_DESCRIPTION,
                        'rules' => array(
                            array('required'),
                            array('min_length', 20)
                        )
                            ))
                )
            )
        );


    }

}
