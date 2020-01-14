<?php
/**
 * Author: Maxim Sidorov
 * Date: 07.09.2015
 * Time: 23:33
 */

class onStreamCronDeleteInactive extends cmsAction{

    public function run(){
        if (empty($this->options['delete_inactive_after'])) return;
        $this->model->deleteInactive($this->options['delete_inactive_after']);
    }
}