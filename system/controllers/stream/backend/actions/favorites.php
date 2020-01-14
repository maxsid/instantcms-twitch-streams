<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 15:25
 */

class actionStreamFavorites extends cmsAction{
    public function run(){
        $grid = $this->loadDataGrid('favorites');
        //javascript:icms.forms.submit()
        return cmsTemplate::getInstance()->render('backend/favorites', array(
            'grid' => $grid
        ));
    }
}