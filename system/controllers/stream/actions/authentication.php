<?php
/**
 * Developer: Sidorov Maxim
 * Email: gen.maxsid@outlook.com
 * Date: 14.08.2015 23:07
 * Distribution is forbidden without the permission of the developer
 */

class actionStreamAuthentication extends cmsAction{

    public function run()
    {

        if (!cmsUser::isLogged()) {
            cmsCore::error404();
        }

        $authInfo = $this->getAuthInfo(cmsUser::get('id'));
        $add = false;

        if ($this->request->has('add')) {
            $add = $this->request->get('add');
        }

        $parsedForm = array();

        if (!$authInfo || array_key_exists('error', $authInfo)) {
            if ($authInfo['error'] == 'missing_api_keys') {
                $this->asm(LANG_STREAM_ERROR_MISSING_API_KEYS, 'error');
            } else if ($authInfo['error'] == 'missing_user_auth_info') {
                $this->asm(LANG_STREAM_ERROR_ACCESS_MISSING, 'error');
                $item = array(
                    'id' => $authInfo['user_id'],
                    'state' => $this->generateState()
                );

                $this->model->setTwitchAuthItem($item);
                $authInfo = $this->getAuthInfo(cmsUser::get('id'));

            } else if ($authInfo['error'] == 'missing_access_token' && !array_key_exists('code', $_REQUEST)) {
                $this->asm(LANG_STREAM_ERROR_ACCESS_MISSING, 'error');
                //return;
            } else {
                $this->asm(LANG_STREAM_ERROR_MISSING_AUTH_INFO, 'error');
            }
        } else {
            if (!is_null($authInfo['response']) && $authInfo['response']['token']['valid']) {
                $parsedForm = $this->parseToForm($authInfo['response']['token']['authorization']['scopes']);
                $this->asm(LANG_STREAM_SET_AUTHENTICATION_IS_SUCCESS, 'success');
            } else {
                $this->asm(LANG_STREAM_ERROR_ACCESS_MISSING, 'error');
            }
        }

        $form = $this->getForm('authentication');
        $is_submitted = $this->request->has('submit');

        $redirectUrl = cmsConfig::get('host').href_to('stream','authentication');

        if ($is_submitted || $add){
            $scope = '';
            if ($is_submitted) {
                $parsedForm = $form->parse($this->request, $is_submitted);

                foreach (array_keys($parsedForm) as $key) {
                    if ($parsedForm[$key]) {
                        $scope .= $key . '+';
                    }
                }
                $scope = substr($scope, 0, -1);
            } else if ($add) {
                if ($authInfo['response'] && $authInfo['response']['token'] && $authInfo['response']['token']['authorization']
                    && $authInfo['response']['token']['authorization']['scopes']){
                    foreach($authInfo['response']['token']['authorization']['scopes'] as $key){
                        $scope .= $key .'+';
                    }
                }

                $scope .= $add;
            }


            $this->redirect('https://api.twitch.tv/kraken/oauth2/authorize'.
                '?response_type=code'.
                '&client_id='.$authInfo['client_id'].
                '&redirect_uri='.$redirectUrl.
                '&scope='.$scope.
                '&state='.$authInfo['user']['state']);
        }

        if (array_key_exists('code', $_REQUEST)){
            $item = $authInfo['user'];
            $item['code'] = $_REQUEST['code'];
            $parsedForm = $this->parseToForm(explode(' ', $_REQUEST['scope']));

            $curl = curl_init('https://api.twitch.tv/kraken/oauth2/token');
            curl_setopt_array($curl, array(
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'client_id' => $authInfo['client_id'],
                    'client_secret' => $authInfo['client_secret'],
                    'grant_type' => 'authorization_code',
                    'redirect_uri' => $redirectUrl,
                    'code' => $item['code'],
                    'state' => $item['state']
                ),
                CURLOPT_RETURNTRANSFER => true
            ));
            $res = curl_exec($curl);
            curl_close($curl);

            $res = json_decode($res, true);

            if (array_key_exists('error', $res)){
                $this->asm(LANG_STREAM_ERROR_BAD_REQUEST. '<br>'.$res['status'].': '.$res['message'], 'error');
            } else {
                $item['access_token'] = $res['access_token'];
                $item['refresh_token'] = $res['refresh_token'];

                $this->model->setTwitchAuthItem($item);
                $authInfo['user'] = $item;
                $this->asm(LANG_STREAM_SET_AUTHENTICATION_IS_SUCCESS, 'success');
            }

        }


        $this->redirectTo('stream');
        $template = cmsTemplate::getInstance();

        $template->render('authentication', array(
            'item' => $parsedForm,
            'form' => $form
        ));
    }

    function generateState($length = 40){
        $chars = 'abdefhiknrstyzABDEFGHKNQRSTYZ23456789';
        $numChars = strlen($chars);
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, rand(1, $numChars) - 1, 1);
        }
        return $string;
    }

    function parseToForm($arr){
        $parsed = array();
        if ($arr === false) return $parsed;
        foreach ($arr as $sc) {
            $parsed[$sc] = 1;
        }
        return $parsed;
    }
    
    function asm($message, $type = 'info'){
        cmsUser::clearSessionMessages();
        cmsUser::addSessionMessage($message, $type);
    }

}