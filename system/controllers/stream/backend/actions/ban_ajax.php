<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 12:46
 */

class actionStreamBanAjax extends cmsAction {

    public function run(){

        if (!$this->request->isAjax()) { cmsCore::error404(); }

        $grid = $this->loadDataGrid('ban');

        $model = cmsCore::getModel('stream');

        $presets = $model->getBannedChannels();

        cmsTemplate::getInstance()->renderGridRowsJSON($grid, $presets);

        $this->halt();
    }

}