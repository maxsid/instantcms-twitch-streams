<?php
/**
 * Author: Maxim Sidorov
 * Date: 26.08.2015
 * Time: 22:55
 */

class actionStreamView extends cmsAction {

    public function run($channel_name = false)
    {
        if (!$channel_name){
            $this->redirectTo('stream');
        }
        $channel = $this->model->getChannelForName($channel_name);
        $is_owner = $channel['owner'] == cmsUser::get('id');
        if (!$channel){
            cmsCore::error404();
        }

        if (!$channel['active'] && (!cmsUser::isAllowed('stream','view_inactive_channels','all') &&
                !(cmsUser::isAllowed('stream','view_inactive_channels','own') && $is_owner))){
            cmsCore::error404();
        }

        $ban = $this->model->getBannedChannel($channel_name);

        $edit_is_allowed = (cmsUser::isAllowed('stream','edit_channels','all') ||
            (cmsUser::isAllowed('stream','edit_channels','own') && $is_owner));
        $delete_is_allowed = (cmsUser::isAllowed('stream','delete_channels','all') ||
            (cmsUser::isAllowed('stream','delete_channels','own') && $is_owner));
        $ban_is_allowed = $channel['active'] && cmsUser::isAllowed('stream','ban_channels');
        $pin_is_allowed = $channel['active'] && cmsUser::isAllowed('stream','pin_channels');
        $list_channels_allowed = cmsUser::isAllowed('stream','view_list_channels','all') ||
            (cmsUser::isAllowed('stream','view_list_channels','own') && $is_owner);
        $owner = cmsCore::getModel('users')->getUser($channel['owner']);

        $owner_url = $list_channels_allowed && $owner ?
            href_to_abs('stream',$channel['owner']) : href_to_abs('users',$channel['owner']);

        $sizes = array(
            'player_width' => empty($this->options['player_width']) ? 640 :  $this->options['player_width'],
            'player_height' => empty($this->options['player_height']) ? 360 :  $this->options['player_height'],
            'chat_width' => empty($this->options['chat_width']) ? 640 :  $this->options['chat_width'],
            'chat_height' => empty($this->options['chat_height']) ? 180 :  $this->options['chat_height']
        );

        $template = cmsTemplate::getInstance();
        $template->render('view', array(
            'channel' => $channel,
            'ban' => $ban,
            'show_chat' => empty($this->options['hide_chat']) ? true : !$this->options['hide_chat'],
            'edit_is_allowed' => $edit_is_allowed,
            'delete_is_allowed' => $delete_is_allowed,
            'ban_is_allowed' => $ban_is_allowed,
            'pin_is_allowed' => $pin_is_allowed,
            'owner' => $owner,
            'owner_url' => $owner_url,
            'sizes' => $sizes
        ));
    }
}