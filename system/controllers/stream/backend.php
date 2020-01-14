<?php
/**
 * Author: Maxim Sidorov
 * Date: 29.08.2015
 * Time: 3:30
 */

class backendStream extends cmsBackend{

    public $useDefaultOptionsAction = true;
    public $useDefaultPermissionsAction = true;

    public function getBackendMenu(){
        return array(
            array(
                'title' => LANG_STREAM_CHANNELS,
                'url' => href_to($this->root_url, 'channels')
            ),
            array(
                'title' => LANG_STREAM_BANNED_CHANNELS,
                'url' => href_to($this->root_url,'ban')
            ),
            array(
                'title' => LANG_STREAM_PINNED_CHANNELS,
                'url' => href_to($this->root_url,'favorites')
            ),
            array(
                'title' => LANG_OPTIONS,
                'url' => href_to($this->root_url, 'options')
            ),
            array(
                'title' => LANG_PERMISSIONS,
                'url' => href_to($this->root_url, 'perms', $this->name)
            ),
        );
    }
}