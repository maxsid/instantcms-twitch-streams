<?php

class actionStreamAdd extends cmsAction
{

    public function run()
    {
        if (!cmsUser::isAllowed('stream','add_channels')) {
            cmsCore::error404();
        }

        $user_channels_count = $this->model->getUserChannelsCount(cmsUser::get('id'));
        $authInfo = false;
        $channel_name = null;
        $form = null;
        $errors = false;
        $parsedForm = array();
        $curl_res = false;

        if (!cmsUser::isAllowed('stream','add_channel_mode')) {
            $authInfo = $this->getAuthInfo();
            if (!$authInfo || !array_key_exists('response', $authInfo) || !$authInfo['response']['token']['valid']) {
                $this->redirectToAction('authentication',false,array('add' => 'channel_read'));
                //cmsUser::addSessionMessage(sprintf(LANG_STREAM_MISSING_TWITCH_CONNECT, href_to('stream', 'authentication').'?add=channel_read'), 'error');
            } else {
                $curl = curl_init('https://api.twitch.tv/kraken/channel');
                curl_setopt_array($curl, array(
                    CURLOPT_HTTPGET => true,
                    CURLOPT_HTTPHEADER => array('Accept: application/vnd.twitchtv.v3+json', 'Authorization: OAuth ' . $authInfo['user']['access_token']),
                    CURLOPT_RETURNTRANSFER => true
                ));
                $curl_res = json_decode(curl_exec($curl),true);
                curl_close($curl);

                if ($this->isCurlExecWithoutErrors($curl_res)) {
                    $channel_name = $curl_res['name'];
                }
            }
        } else {
            $form = $this->getForm('add_channel');
            $is_submitted = $this->request->has('submit');
            if ($is_submitted) {
                $parsedForm = $form->parse($this->request, $is_submitted);
                $errors = $form->validate($this, $parsedForm);
                if ($errors) {
                    cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');
                } else if (!$errors) {
                    $channel_name = $parsedForm['channel_name'];
                }
            }
        }

        if ($channel_name) {
            if (cmsUser::isPermittedLimitReached('stream','max_count',$user_channels_count)) {
                cmsUser::addSessionMessage(LANG_STREAM_ERROR_NO_MORE_CHANNEL, 'error');
            } else {
                if ($this->model->getChannelForName($channel_name)) {
                    cmsUser::addSessionMessage(sprintf(LANG_STREAM_ERROR_CHANNEL_THIS_NAME_REGISTERED, $channel_name), 'error');
                } else {
                    if ($ch = $this->model->getBannedChannel($channel_name)) {
                        cmsUser::addSessionMessage(sprintf(LANG_STREAM_ERROR_CHANNEL_IS_BANNED, $channel_name, $ch['reason']), 'error');
                    } else {
                        if (!$curl_res) {
                            $curl = curl_init('https://api.twitch.tv/kraken/channels/' . $channel_name);
                            curl_setopt_array($curl, array(
                                CURLOPT_HTTPGET => true,
                                CURLOPT_HTTPHEADER => array('Accept: application/vnd.twitchtv.v3+json'),
                                CURLOPT_RETURNTRANSFER => true
                            ));
                            $curl_res = json_decode(curl_exec($curl), true);
                            curl_close($curl);
                        }


                        if ($this->isCurlExecWithoutErrors($curl_res)) {
                            //¬от тут все хорошо теперь
                            //“ут потом можно ограничение на просмотры поставить
                            $send_array = array(
                                'id' => $curl_res['_id'],
                                'name' => $curl_res['name'],
                                'title' => $curl_res['display_name'],
                                'owner' => cmsUser::get('id')
                            );
                            $this->model->setChannel($send_array);
                            cmsUser::addSessionMessage(sprintf(LANG_STREAM_ADDED_CHANNEL_IS_SUCCESS, $send_array['name']), 'success');
                            $this->redirectToAction($curl_res['name'], 'edit');
                        }
                    }
                }
            }

        }


        $template = cmsTemplate::getInstance();

        if (!cmsUser::isAdmin()) {
            $this->redirectTo('stream');
        } else {
            $template->render('add_channel', array(
                'form' => $form,
                'errors' => $errors,
                'parsedForm' => $parsedForm
            ));
        }
    }
}
