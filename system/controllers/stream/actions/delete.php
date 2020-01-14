<?php
/**
 * Author: Maxim Sidorov
 * Date: 31.08.2015
 * Time: 3:32
 */

class actionStreamDelete extends cmsAction{

    public function run($channel_name){
        if (!$channel_name){
            cmsCore::error404();
        }

        $channel = $this->model->getChannelForName($channel_name);
        if (!$channel){
            cmsCore::error404();
        }

        $is_owner = $channel['owner'] == cmsUser::get('id');
        if (!cmsUser::isAllowed('stream','delete_channels','all') &&
                !(cmsUser::isAllowed('stream','delete_channels','own') && $is_owner)) {
            cmsCore::error404();
        }


        $errors = false; $parsedForm = array();
        $form = $this->getForm('delete_channel');
        $is_submitted = $this->request->has('submit');
        if ($is_submitted) {
            $parsedForm = $form->parse($this->request, $is_submitted);
            $errors = $form->validate($this, $parsedForm);
            if ($errors) {
                cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');
            } else if (!$errors) {
                if ($parsedForm['confirm_deletion']){
                $this->model->deleteChannel($channel['id']);
                cmsUser::addSessionMessage(LANG_STREAM_DELETED_CHANNEL_IS_SUCCESS, 'success');
                $this->redirectTo('stream');
                } else {
                    cmsUser::addSessionMessage(LANG_STREAM_DELETE_CHANNEL_CANCELLED, 'success');
                    $this->redirectToAction($channel['name']);
                }
            }
        }

        $template = cmsTemplate::getInstance();
        $template->render('delete_channel', array(
            'form' => $form,
            'errors' => $errors,
            'parsedForm' => $parsedForm,
            'channel' => $channel
        ), $errors);
    }
}