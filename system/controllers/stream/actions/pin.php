<?php
/**
 * Author: Maxim Sidorov
 * Date: 31.08.2015
 * Time: 18:32
 */

class actionStreamPin extends cmsAction{

    public function run($channel_name){
        if (!$channel_name || !cmsUser::isAllowed('stream','pin_channels')){
            cmsCore::error404();
        }

        $channel = $this->model->getChannelForName($channel_name);
        if (!$channel || !$channel['active']){
            cmsCore::error404();
        }

        if (!$channel['pinned'] || ($this->request->has('position') && $this->request->get('position') == 0)) {
            $position = ($this->request->has('position') && $this->request->get('position') == 0) ?
                $this->model->setPinnedChannel($channel['id'],0) : $this->model->setPinnedChannel($channel['id']);
            if ($position > 0) {
                cmsUser::addSessionMessage(sprintf(LANG_STREAM_PINNED_IS_SUCCESS, $position), 'success');
            } else {
                cmsUser::addSessionMessage(LANG_STREAM_UNPINED, 'success');
            }
        } else {
            cmsUser::addSessionMessage(LANG_STREAM_ALREADY_PINNED, 'error');
        }

        $this->redirectBack();
    }
}
