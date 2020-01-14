<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 15:26
 */

function grid_favorites($controller){
    $options = array(
        'is_sortable' => false,
        'is_filter' => false,
        'is_pagination' => false,
        'is_draggable' => true,
        'order_by' => 'pinned',
        'order_to' => 'asc',
        'show_id' => true
    );

    $columns = array(
        'pinned' => array(
            'title' => LANG_STREAM_PINNED_POSITION,
            'width' => 20,
        ),
        'name' => array(
            'title' => LANG_STREAM_CHANNEL,
        )
    );
    $actions = array(
        array(
            'title' => LANG_STREAM_UNPIN,
            'class' => 'delete',
            'href' => href_to('stream','{name}','unpin')
        )
    );

    return array(
        'options' => $options,
        'columns' => $columns,
        'actions' => $actions
    );
}