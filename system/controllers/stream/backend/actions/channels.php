<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 9:37
 */

class actionStreamChannels extends cmsAction{

    public function run(){
        $grid = $this->loadDataGrid('channels');
        $model = cmsCore::getModel('stream');

        /*$count = array(
            'all' => $model->getAllChannelsCount(),
            'active' => $model->getActiveChannelsCount(),
            'inactive' => $model->getInactiveCount(),
        );*/
        //var_dump($model->getAllChannelsCount());
        //var_dump($model->getActiveChannelsCount());
        //var_dump($model->getInactiveCount());

        return cmsTemplate::getInstance()->render('backend/channels', array(
            'grid' => $grid,
            //'count' => $count
        ));
    }
}