<?php
/**
 * Author: Maxim Sidorov
 * Date: 01.09.2015
 * Time: 12:28
 */

class actionStreamBan extends cmsAction{

    public function run($do = false, $channel_name = false){
        if (!$do) {
            $grid = $this->loadDataGrid('ban');

            return cmsTemplate::getInstance()->render('backend/ban', array(
                'grid' => $grid
            ));
        } else if ($do == 'add') {
            $model = cmsCore::getModel('stream');
            $form = $this->getForm('ban');
            $parsedForm = array(); $errors = false;

            if ($channel_name) {
                $parsedForm['name'] = $channel_name;
            }

            $is_submitted = $this->request->has('submit');
            if ($is_submitted){
                $parsedForm = $form->parse($this->request, $is_submitted);
                $errors = $form->validate($this, $parsedForm);
                if ($errors) {
                    cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');
                } else if (!$errors) {
                    $model->banChannel($parsedForm['name'], $parsedForm['reason']);
                    cmsUser::addSessionMessage(sprintf(LANG_STREAM_CHANNEL_BAN_IS_ACCESS, $parsedForm['name']), 'success');
                    $this->redirectToAction('ban');
                }
            }
            return cmsTemplate::getInstance()->render('backend/ban', array(
                'form' => $form,
                'parsedForm' => $parsedForm,
                'errors' => $errors
            ));
        } else if ($do == 'del'){
            if ($channel_name) {
                $model = cmsCore::getModel('stream');
                $model->unbanChannel($channel_name);
                cmsUser::addSessionMessage(sprintf(LANG_STREAM_CHANNEL_UNBAN_IS_ACCESS, $channel_name), 'success');
                $this->redirectToAction('ban');
            } else {
                cmsCore::error404();
            }
        }
    }
}