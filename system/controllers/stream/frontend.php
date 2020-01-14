<?php

class stream extends cmsFrontend {

    protected $useOptions = true;

    public function routeAction($action_name)
    {
        $actions = array(
            'add',
            'authentication',
            'index',
            'favorites_reorder',
            'auth'
        );
        if (in_array($action_name, $actions)) {
            return $action_name;
        }

        $actions = array(
            'online',
            'offline',
            'banned',
            'all'
        );
        if (in_array($action_name, $actions) || is_numeric($action_name)
        ) {
            $this->current_params[0] = $action_name;
            return 'index';
        }


        if (!empty($this->current_params[0])) {
            if ($this->current_params[0] == 'unban') {
                $this->current_params[0] = $action_name;
                $this->current_params[1] = 'unban';
                return 'ban';
            }

            if ($this->current_params[0] == 'unpin'){
                $this->current_params[0] = $action_name;
                $this->request->set('position',0);
                return 'pin';
            }

            if (!$this->isActionExists($this->current_params[0])) return;

            $real_action = $this->current_params[0];
            $this->current_params[0] = $action_name;
            return $real_action;
        }

        $this->current_params[0] = $action_name;
        return 'view';
    }

    public function getAuthInfo($user_id = null)
    {
        if (is_null($user_id)) $user_id = cmsUser::get('id');
        if (empty($this->options['client_id']) ||
            empty($this->options['client_secret'])
        ) {
            return array(
                'user_id' => $user_id,
                'error' => 'missing_api_keys'
            );
        }
        $user_item = $this->model->getTwitchAuthItem($user_id);
        if (!$user_item) {
            return array(
                'user_id' => $user_id,
                'client_id' => $this->options['client_id'],
                'client_secret' => $this->options['client_secret'],
                'error' => 'missing_user_auth_info'
            );
        } else if (!$user_item['access_token']) {
            return array(
                'user_id' => $user_id,
                'client_id' => $this->options['client_id'],
                'client_secret' => $this->options['client_secret'],
                'error' => 'missing_access_token',
                'user' => $user_item
            );
        }

        $curl = curl_init('https://api.twitch.tv/kraken');
        curl_setopt_array($curl, array(
            CURLOPT_HTTPHEADER => array(
                'Accept: application/vnd.twitchtv.v3+json',
                'Authorization: OAuth ' . $user_item['access_token']
            ),
            CURLOPT_RETURNTRANSFER => true
        ));
        $response = curl_exec($curl);
        $errno = curl_errno($curl);
        curl_close($curl);

        $response = json_decode($response, true);

        return array(
            'user_id' => $user_id,
            'client_id' => $this->options['client_id'],
            'client_secret' => $this->options['client_secret'],
            'user' => $user_item,
            'response' => $response,
            'response_error' => $errno
        );
    }

    public function isExistsScope($scope, $scopes_array){
        foreach($scopes_array as $sc){
            if ($sc == $scope) return true;
        }
        return false;
    }


    public function isCurlExecWithoutErrors($curl_res)
    {
        if (!$curl_res) return false;
        if (array_key_exists('error', $curl_res)) {
            switch ($curl_res['status']) {
                case 404:
                    cmsUser::addSessionMessage(sprintf(LANG_STREAM_ERROR_CHANNEL_NOT_FOUND, $this->request->get('channel_name')), 'error');
                    break;
                case 422:
                    cmsUser::addSessionMessage(sprintf(LANG_STREAM_ERROR_CHANNEL_UNPROCESSABLE_ENTITY, $this->request->get('channel_name')), 'error');
                    break;
                case 401:
                    cmsUser::addSessionMessage(sprintf(LANG_STREAM_ERROR_UNAUTHORIZED, href_to('stream','authentication').'?add=channel_read'), 'error');
                    break;
                default:
                    cmsUser::addSessionMessage(LANG_STREAM_ERROR_BAD_REQUEST . '\n' . $curl_res['status'] . ': ' . $curl_res['message'], 'error');
            }
            return false;
        }
        //print '<pre>';  print_r($curl_res); print '</pre>'; return false;
        return true;
    }
}