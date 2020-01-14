<?php
/**
 * Author: Maxim Sidorov
 * Date: 28.08.2015
 * Time: 16:55
 */

class actionStreamBan extends cmsAction
{

    public function run($channel_name = false, $unban = false)
    {

        if (!$channel_name || !cmsUser::isAllowed('stream','ban_channels') || ($unban != 'unban' && $unban)) {
            cmsCore::error404();
        }
        $channel = $this->model->getChannelForName($channel_name);
        if (!$channel || !$channel['active']){
            cmsCore::error404();
        }

        $form = $this->getForm('ban_channel');
        $is_submitted = $this->request->has('submit');
        $parsedForm = $form->parse($this->request, $is_submitted);
        $errors = $form->validate($this, $parsedForm);

        if ($is_submitted) {
            if ($errors) {
                cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');
            } else if (!$errors) {
                $this->model->banChannel($parsedForm['name'], $parsedForm['reason']);
                cmsUser::addSessionMessage(sprintf(LANG_STREAM_CHANNEL_BAN_IS_ACCESS, $parsedForm['name']), 'success');
            }
        } else {
            if ($unban) {
                $this->model->unbanChannel($channel_name);
                cmsUser::addSessionMessage(sprintf(LANG_STREAM_CHANNEL_UNBAN_IS_ACCESS, $channel_name), 'success');
            } else {
                $parsedForm = array(
                    'name' => $channel_name);
            }
        }
        cmsTemplate::getInstance()->render('ban_channel', array(
            'form' => $form,
            'parsedForm' => $parsedForm,
            'errors' => $errors,
            'channel' => $channel
        ));
    }
}
