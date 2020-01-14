<?php
/**
 * Author: Maxim Sidorov
 * Date: 29.08.2015
 * Time: 4:04
 */

function grid_channels($controller){
    $options = array(
        'is_sortable' => true,
        'is_filter' => true,
        'is_pagination' => true,
        'is_draggable' => false,
        'order_by' => 'added_time',
        'order_to' => 'desc',
        'show_id' => true
    );

    $columns = array(
        'id' => array(
            'title' => 'id', // Заголовок столбца
            'width' => 30, // Ширина столбца, в пикселях
            'filter' => 'exact' // Фильтр по столбцу - искать точные совпадения
        ),
        'name' => array(
            'title' => LANG_STREAM_CHANNEL,
            'filter' => 'like'
        ),
        'title' => array(
            'title' => LANG_STREAM_DISPLAYED_NAME,
            'filter' => 'like'
        ),
        'owner' => array(
            'title' => LANG_STREAM_OWNER,
            'filter' => 'like',
            'handler' => function ($field, $row){
                return cmsCore::getModel('users')->getUser($field)['nickname'];
            },
            'href' => href_to('users','{owner}')
        ),
        'added_time' => array(
            'title' => LANG_STREAM_ADD_CHANNEL_DATE,
            'handler' => function($field, $row){
                return date('d.m.Y H:i:s', strtotime($field));
            }
        ),
        'active' => array(
            'title' => LANG_STREAM_ACTIVE,
            'handler' => function ($field, $row){
                return $field ? LANG_YES : LANG_NO;
            }
        )

    );
    $actions = array(
        array(
            'title' => LANG_STREAM_TO_CHANNEL,
            'class' => 'view',
            'href' => href_to('stream','{name}')
        ),
        array(
            'title' => LANG_STREAM_EDIT,
            'class' => 'edit',
            'href' => href_to('stream','{name}','edit')
        ),
        array(
            'title' => LANG_STREAM_PIN_CHANNEL,
            'class' => 'permissions',
            'href' => href_to('stream','{name}','pin')
        ),
        array(
            'title' => LANG_STREAM_CHANNEL_BAN,
            'class' => 'unbind',
            'href' => href_to($controller->root_url,'ban',array('add','{name}'))
        ),
        array(
            'title' => LANG_STREAM_DELETE_CHANNEL,
            'class' => 'delete',
            'href' => href_to('stream','{name}','delete')
        )
    );

    return array(
        'options' => $options,
        'columns' => $columns,
        'actions' => $actions
    );
}