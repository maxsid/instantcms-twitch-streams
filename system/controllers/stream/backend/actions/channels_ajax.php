<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 9:38
 */

class actionStreamChannelsAjax extends cmsAction {

    public function run(){

        if (!$this->request->isAjax()) { cmsCore::error404(); }

        $grid = $this->loadDataGrid('channels');

        $model = cmsCore::getModel('stream');

        $presets = $model->getAllChannels();

        cmsTemplate::getInstance()->renderGridRowsJSON($grid, $presets);

        $this->halt();
    }

}