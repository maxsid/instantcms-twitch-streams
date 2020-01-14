<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 15:47
 */

class actionStreamFavoritesAjax extends cmsAction{
    public function run(){
        if (!$this->request->isAjax()) { cmsCore::error404(); }

        $grid = $this->loadDataGrid('favorites');

        $model = cmsCore::getModel('stream');

        $presets = $model->getPinnedChannels();

        cmsTemplate::getInstance()->renderGridRowsJSON($grid, $presets);

        $this->halt();
    }
}