<?php
/**
 * Author: Maxim Sidorov
 * Date: 05.09.2015
 * Time: 7:45
 */

class actionStreamFavoritesReorder extends cmsAction{

    public function run(){
        $items = $this->request->get('items');
        if (!$items){ cmsCore::error404(); }

        $this->model->reorderChannelsPositions($items);

        $this->redirectBack();
    }
}