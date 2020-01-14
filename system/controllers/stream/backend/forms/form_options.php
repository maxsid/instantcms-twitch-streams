<?php
/**
 * Author: Maxim Sidorov
 * Date: 29.08.2015
 * Time: 3:34
 */

class formStreamOptions extends cmsForm
{

    public function init()
    {
        return array(
            array(
                'type' => 'fieldset',
                'title' => 'Twitch API',
                'childs' => array(
                    new fieldString('client_id', array(
                        'title' => 'ClientID'
                    )),
                    new fieldString('client_secret', array(
                        'title' => 'Client Secret'
                    ))
                )
            ),
            array(
                'type' => 'fieldset',
                'title' => LANG_STREAM_OPTIONS_PLAYER_SIZE,
                'childs' => array(
                    new fieldString('player_width', array(
                        'title' => LANG_STREAM_WIDTH,
                        'default' => 640
                    )),
                    new fieldString('player_height', array(
                        'title' =>  LANG_STREAM_HEIGHT,
                        'hint' => LANG_STREAM_RECOMMENDED_RATIO,
                        'default' => 360
                    ))
                )
            ),
            array(
                'type' => 'fieldset',
                'title' => LANG_STREAM_OPTIONS_CHAT_SIZE,
                'childs' => array(
                    new fieldString('chat_width', array(
                        'title' => LANG_STREAM_WIDTH,
                        'default' => 640
                    )),
                    new fieldString('chat_height', array(
                        'title' =>  LANG_STREAM_HEIGHT,
                        'default' => 180
                    ))
                )
            ),
            array(
                'type' => 'fieldset',
                'childs' => array(
                    new fieldNumber('count_on_page', array(
                        'title' => LANG_STREAM_COUNT_STREAMS_ON_PAGE,
                        'default' => 25
                    )),
                    new fieldCheckbox('hide_chat',array(
                        'title' => LANG_STREAM_HIDE_CHAT,
                        'default' => false
                    )),
                    new fieldNumber('delete_inactive_after', array(
                        'title' => LANG_STREAM_OPTIONS_DELETE_INACTIVE_AFTER,
                        'hint' => LANG_STREAM_OPTIONS_DELETE_INACTIVE_AFTER_HINT
                    ))
                )
            )
            );
    }
}