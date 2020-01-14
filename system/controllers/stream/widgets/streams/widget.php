<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 16:15
 */

class widgetStreamStreams extends cmsWidget{

    public function run()
    {
        $model = cmsCore::getModel('stream');
        $limit = $this->getOption('limit', 10);
        $is_hiding = true;
        $show_pinned_online = $this->getOption('show_pinned_online', true);
        $show_pinned_offline = $this->getOption('show_pinned_offline', true);
        $show_online = $this->getOption('show_online', true);
        $show_offline = $this->getOption('show_offline', true);
        $res_channels = array(
            'pinned_online' => array(),
            'pinned_offline' => array(),
            'online' => array(),
            'offline' => array()
        );
        $channels = $model->getActiveChannels();
        if (!$channels && $is_hiding) {
            return false;
        } else if ($channels) {
            $all_channels = array(
                'pinned_online' => array(),
                'pinned_offline' => array(),
                'online' => array(),
                'offline' => array()
            );
            $query = '';
            foreach ($channels as $ch) {
                $query .= $ch['name'] . ',';
            }
            $query = substr($query, 0, -1);

            $res_curl = array();
            $total = 0;
            $next_url = 'https://api.twitch.tv/kraken/streams?limit=100&channel=' . $query;
            do {
                $curl = curl_init($next_url);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $res = json_decode(curl_exec($curl), true);
                $this->addArrayInArray($res_curl, $res);
                curl_close($curl);
                $total = $res['_total'];
                $next_url = $res['_links']['next'];
            } while (count($res_curl) < $total);
            foreach ($channels as $c) {
                $i = 0;
                $finded = false;
                for (; $i < count($res_curl['streams']); $i++) {
                    if (array_key_exists($i, $res_curl['streams']) && $c['id'] == $res_curl['streams'][$i]['channel']['_id']) {
                        $finded = true;
                        break;
                    }
                }
                $c['logo'] = $model->yamlToArray($c['logo']);
                if ($finded) {
                    $c['stream'] = $res_curl['streams'][$i];
                    if ($c['pinned'] && $show_pinned_online)
                        $all_channels['pinned_online'][] = $c;
                    else if (!$c['pinned'] && $show_online)
                        $all_channels['online'][] = $c;
                    unset($res_curl['streams'][$i]);
                } else {
                    if ($c['pinned'] && $show_pinned_offline)
                        $all_channels['pinned_offline'][] = $c;
                    else if (!$c['pinned'] && $show_offline)
                        $all_channels['offline'][] = $c;
                }
            }

            $model->quick_sort($all_channels['online'], array('stream', 'viewers'));
            $model->quick_sort($all_channels['pinned_online'], array('pinned'), true);
            $model->quick_sort($all_channels['pinned_offline'], array('pinned'), true);

            $count = 0;
            foreach(array('pinned_online','online','pinned_offline','offline') as $cur){
                foreach($all_channels[$cur] as $v){
                    if (++$count > $limit) break;
                    $res_channels[$cur][] = $v;
                }
                if ($count >= $limit) break;
            }
        }

        if (!$res_channels['online'] && !$res_channels['pinned_online'] && !$res_channels['pinned_offline'] && $res_channels['offline'])
            return false;

        return array(
            'channels' => $res_channels,
            'limit' => $limit
        );
    }


    function addArrayInArray(&$toArray,$fromArray){
        if (count($toArray) == 0) {$toArray = $fromArray; return;}
        foreach($fromArray as $el){
            $toArray[] = $el;
        }
    }
}
