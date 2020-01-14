<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 16:59
 */

class formWidgetStreamStreamsOptions extends cmsForm
{
    public function init()
    {
        return array(
            array(
                'type' => 'fieldset',
                'title' => LANG_OPTIONS,
                'childs' => array(
                    new fieldNumber('options:limit', array(
                        'title' => LANG_WD_STREAM_MAX_COUNT_STREAM,
                        'default' => 10,
                        'rules' => array(
                            array('required')
                        ))),
                    new fieldCheckbox('options:is_hiding', array(
                        'title' => LANG_WD_STREAM_OFF_IF_EMPTY,
                        'default' => true,
                    )),
                    new fieldCheckbox('options:show_pinned_online', array(
                        'title' => LANG_WD_STREAM_SHOW_PINNED_ONLINE,
                        'default' => true,
                    )),
                    new fieldCheckbox('options:show_online', array(
                        'title' => LANG_WD_STREAM_SHOW_ONLINE,
                        'default' => true,
                    )),
                    new fieldCheckbox('options:show_pinned_offline', array(
                        'title' => LANG_WD_STREAM_SHOW_PINNED_OFFLINE,
                        'default' => true,
                    )),
                    new fieldCheckbox('options:show_offline', array(
                        'title' => LANG_WD_STREAM_SHOW_OFFLINE,
                        'default' => true,
                    ))
                )),
        );
    }
}