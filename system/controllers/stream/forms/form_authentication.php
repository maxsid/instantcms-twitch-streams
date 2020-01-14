<?php
/**
 * Developer: Sidorov Maxim
 * Email: gen.maxsid@outlook.com
 * Date: 15.08.2015 22:55
 * Distribution is forbidden without the permission of the developer
 */

class formStreamAuthentication extends cmsForm{
    public function init() {
        return array(
            array(
                'type' => 'fieldset',
                'childs' => array(
                    new fieldCheckbox('user_read', array(
                        'title' => LANG_STREAM_SCOPE_INFO_USER_READ
                    )),
                    new fieldCheckbox('user_blocks_edit', array(
                        'title' => LANG_STREAM_SCOPE_INFO_USER_BLOCKS_EDIT
                    )),
                    new fieldCheckbox('user_blocks_read', array(
                        'title' => LANG_STREAM_SCOPE_INFO_USER_BLOCKS_READ
                    )),
                    new fieldCheckbox('user_follows_edit', array(
                        'title' => LANG_STREAM_SCOPE_INFO_USER_FOLLOWS_EDIT
                    )),
                    new fieldCheckbox('channel_read', array(
                        'title' => LANG_STREAM_SCOPE_INFO_CHANNEL_READ
                    )),
                    new fieldCheckbox('channel_editor', array(
                        'title' => LANG_STREAM_SCOPE_INFO_CHANNEL_EDITOR
                    )),
                    new fieldCheckbox('channel_commercial', array(
                        'title' => LANG_STREAM_SCOPE_INFO_CHANNEL_COMMERCIAL
                    )),
                    new fieldCheckbox('channel_stream', array(
                        'title' => LANG_STREAM_SCOPE_INFO_CHANNEL_STREAM
                    )),
                    new fieldCheckbox('channel_subscriptions', array(
                        'title' => LANG_STREAM_SCOPE_INFO_CHANNEL_SUBSCRIPTIONS
                    )),
                    new fieldCheckbox('user_subscriptions', array(
                        'title' => LANG_STREAM_SCOPE_INFO_USER_SUBSCRIPTIONS
                    )),
                    new fieldCheckbox('channel_check_subscription', array(
                        'title' => LANG_STREAM_SCOPE_INFO_CHANNEL_CHECK_SUBSCRIPTIONS
                    )),
                    new fieldCheckbox('chat_login', array(
                        'title' => LANG_STREAM_SCOPE_INFO_CHAT_LOGIN
                    ))
                )
            )
        );
    }
}