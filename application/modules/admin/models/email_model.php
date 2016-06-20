<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of email_model
 *
 * @author johan
 */
class email_model extends CI_Model {

    public function user_approval($id) {

        $user = $this->admin_model->get_user_by_id($id);
        $message = $this->load->view('email/user_approval',array(
            'user'=>$user
        ),true);

        $this->email->from('johankristian0@gmail.com');
        $this->email->to($user->email);
        $this->email->subject('Approve Email');
        $this->email->message($message);
        try {
            $this->email->send();
        } catch (Exception $exc) {
            //Email sent failed
        }
    }

}
