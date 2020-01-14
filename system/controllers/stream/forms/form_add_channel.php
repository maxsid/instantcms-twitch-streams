<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 25.08.2015
 * Time: 17:46
 */

class formStreamAddChannel extends cmsForm{

    public function init(){
        return array(
            array(
                'type' => 'fieldset',
                'childs' => array(
                    new fieldString('channel_name', array(
                        'title' => LANG_STREAM_NAME_TWITCH_CHANNEL,
                        'rules' => array(
                            array('required')
                        )
                    ))
                )
            )
        );
    }
}