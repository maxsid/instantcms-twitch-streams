<?php
/**
 * Author: Maxim Sidorov
 * Date: 28.08.2015
 * Time: 17:18
 */

class formStreamBanChannel extends cmsForm{

    public function init(){
        return array(
            array(
                'type' => 'fieldset',
                'childs' => array(
                    new fieldString('name', array(
                        'title' => LANG_STREAM_NAME_TWITCH_CHANNEL,
                        'rules' => array(
                            array('required')
                        )
                    )),
                    new fieldText('reason', array(
                        'title' => LANG_STREAM_CHANNEL_BAN_REASON,
                        'rules' => array(
                            array('required'),
                            array('min_length', 5)
                        )
                    ))
                )
            )
        );
    }
}
