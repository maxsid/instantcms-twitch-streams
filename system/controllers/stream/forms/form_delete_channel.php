<?php
/**
 * Author: Maxim Sidorov
 * Date: 31.08.2015
 * Time: 3:47
 */

class formStreamDeleteChannel extends cmsForm{

    public function init(){
        return array(
            array(
                'type' => 'fieldset',
                'childs' => array(
                    new fieldCheckbox('confirm_deletion',array(
                        'title' => LANG_STREAM_DELETE_CHANNEL
                    ))
                )
            )
        );
    }
}