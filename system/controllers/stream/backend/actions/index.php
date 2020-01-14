<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 9:36
 */

class actionStreamIndex extends cmsAction{
    public function run(){
        $this->redirectToAction('channels');
    }
}