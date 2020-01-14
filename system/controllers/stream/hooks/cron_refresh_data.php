<?php
/**
 * Author: Maxim Sidorov
 * Date: 08.09.2015
 * Time: 2:18
 */

class onStreamCronRefreshData extends cmsAction{

    public function run(){
        $channels = $this->model->getActiveChannels();
        if (!$channels) return;
        $query = '';
        foreach($channels as $ch){
            $ch['name'] 
        }
    }
}