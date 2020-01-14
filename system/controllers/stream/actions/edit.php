<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 26.08.2015
 * Time: 18:19
 */

class actionStreamEdit extends cmsAction {


    public function run($channel_name = false)
    {
        if (!$channel_name){
            cmsCore::error404();
        }

        $channel = $this->model->getChannelForName($channel_name);
        if (!$channel){
            cmsCore::error404();
        }

        $is_owner = $channel['owner'] == cmsUser::get('id');
        if (!cmsUser::isAllowed('stream','edit_channels','all') &&
            !(cmsUser::isAllowed('stream','edit_channels','own') && $is_owner)) {
            cmsCore::error404();
        }

        $errors = false; $parsedForm = $channel;
        $form = $this->getForm('edit_channel');
        $is_submitted = $this->request->has('submit');
        if ($is_submitted) {
            $parsedForm = $form->parse($this->request, $is_submitted);
            $errors = $form->validate($this, $parsedForm);
            if ($errors) {
                cmsUser::addSessionMessage(LANG_FORM_ERRORS, 'error');
            } else if (!$errors) {
                $channel = array_merge($channel, $parsedForm);
                $channel['active'] = 1; //Проверка админом
                $this->model->setChannel($channel);

                $this->redirectToAction($channel_name);
            }
        }

        $template = cmsTemplate::getInstance();
        $template->render('edit_channel', array(
            'form' => $form,
            'errors' => $errors,
            'parsedForm' => $parsedForm,
            'channel' => $channel,
            'is_owner' => $is_owner
        ));
    }
}