<?php

class actionStreamIndex extends cmsAction {
    
    public function run($do = false){
        if (!$do){
            $this->redirectToAction('all');
        }

        $show_online = ($do == 'online' || $do == 'all' || is_numeric($do));
        $show_offline = ($do == 'offline' || $do == 'all' || is_numeric($do));
        $is_owner = false;
        $list_channels_allowed = cmsUser::isAllowed('stream','view_list_channels','all') ||
            (cmsUser::isAllowed('stream','view_list_channels','own') && $is_owner);
        if (is_numeric($do)){
            $is_owner = cmsUser::get('id') == $do;
            if (!$list_channels_allowed){
                cmsCore::error404();
            }
        }

        $res_channels = array(
            'pinned_online' => array(),
            'pinned_offline' => array(),
            'online' => array(),
            'offline' => array()
        );
        $limit = empty($this->options['count_on_page']) ? 25 : $this->options['count_on_page'];
        $template = cmsTemplate::getInstance();
        $pages  = array(
            'total' => 1,
            'current' => $this->request->has('page') ? $this->request->get('page') : 1,
            'links' => array()
        );
        $channels = array();

        if (is_numeric($do)) {
            $channels = $this->model->getChannelsForOwner($do);
        } else {
            $channels = $this->model->getActiveChannels();
        }

        if ($channels) {
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
            $all_channels_count = 0;
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
                if (!$c['active'] && (!cmsUser::isAllowed('stream','view_inactive_channels','all') &&
                    !(cmsUser::isAllowed('stream','view_inactive_channels','own') && $is_owner))){
                    continue;
                }
                $i = 0;
                $finded = false;
                for (; $i < count($res_curl['streams']); $i++) {
                    if (array_key_exists($i, $res_curl['streams']) && $c['id'] == $res_curl['streams'][$i]['channel']['_id']) {
                        $finded = true;
                        break;
                    }
                }
                $c['logo'] = $this->model->yamlToArray($c['logo']);
                if ($finded && $show_online) {
                    $all_channels_count++;
                    $c['stream'] = $res_curl['streams'][$i];
                    if ($c['pinned'])
                        $all_channels['pinned_online'][] = $c;
                    else
                        $all_channels['online'][] = $c;
                    unset($res_curl['streams'][$i]);
                } else if (!$finded && $show_offline) {
                    $all_channels_count++;
                    if ($c['pinned'])
                        $all_channels['pinned_offline'][] = $c;
                    else
                        $all_channels['offline'][] = $c;
                }
            }

            $pages['total'] = (int)ceil($all_channels_count / $limit) == 0 ? 1 : (int)ceil($all_channels_count / $limit);
            if ($pages['total'] < $pages['current']) $this->redirectToAction($do);
            $start_channel = ($limit * ($pages['current'] - 1)) + 1;

            $this->model->quick_sort($all_channels['online'], array('stream', 'viewers'));
            $this->model->quick_sort($all_channels['pinned_online'], array('pinned'), true);
            $this->model->quick_sort($all_channels['pinned_offline'], array('pinned'), true);

            $count = 0;
            $cur_channel = 0;
            foreach (array('pinned_online', 'online', 'pinned_offline', 'offline') as $cur) {
                foreach ($all_channels[$cur] as $v) {
                    if (++$cur_channel < $start_channel) continue;
                    if (++$count > $limit) break;
                    $res_channels[$cur][] = $v;
                }
                if ($count >= $limit) break;
            }
        }

        //$pages['links'][1] = cmsConfig::get('host').href_to('stream',$do);
        for ($i = 1; $i <= $pages['total'];$i++){
            $pages['links'][$i] = cmsConfig::get('host').href_to('stream',$do).'?page='.$i;
        }

        $user_channels_count = $this->model->getUserChannelsCount(cmsUser::get('id'));
        $add_is_allowed = cmsUser::isAllowed('stream','add_channels') &&
            !cmsUser::isPermittedLimitReached('stream','max_count', $user_channels_count);

        $size = array('width' => 450);
        $size['height'] = intval($size['width'] / 2);

        $template->render('index', array(
            'do' => $do,
            'channels' => $res_channels,
            'user_channels_count' => $user_channels_count,
            'pages' => $pages,
            'add_is_allowed' => $add_is_allowed,
            'size' => $size
        ));
    }

    function addArrayInArray(&$toArray,$fromArray){
        if (count($toArray) == 0) {$toArray = $fromArray; return;}
        foreach($fromArray as $el){
            $toArray[] = $el;
        }
    }
}
