<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 12:41
 */

function grid_ban($controller){
    $options = array(
        'is_sortable' => true,
        'is_filter' => true,
        'is_pagination' => true,
        'is_draggable' => false,
        'order_by' => 'ban_date',
        'order_to' => 'desc',
        'show_id' => true
    );

    $columns = array(
        'name' => array(
            'title' => LANG_STREAM_CHANNEL,
            'filter' => 'like'
        ),
        'reason' => array(
            'title' => LANG_STREAM_CHANNEL_BAN_REASON,
            'filter' => 'like'
        ),
        'owner' => array(
            'title' => LANG_STREAM_BAN_OWNER,
            'filter' => 'like',
            'handler' => function ($field, $row){
                return cmsCore::getModel('users')->getUser($field)['nickname'];
            },
            'href' => href_to('users','{owner}')
        ),
        'date_ban' => array(
            'title' => LANG_STREAM_BANNED,
            'handler' => function($field, $row){
                return date('d.m.Y H:i:s', strtotime($field));
            }
        )
    );
    $actions = array(
        array(
            'title' => LANG_STREAM_UNBAN,
            'class' => 'delete',
            'href' => href_to($controller->root_url,'ban',array('del','{name}'))
        )
    );

    return array(
        'options' => $options,
        'columns' => $columns,
        'actions' => $actions
    );
}