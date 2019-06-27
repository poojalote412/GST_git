<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login_model extends CI_Model {

    public function login_validation($user_id, $pass) {
        $q = $this->db->get_where("user_header_all", array('user_id' => $user_id, 'password' => $pass));

        if ($q->num_rows() === 1) {
            $result = $q->row();
            $user_type = $result->user_type;
            $user_id = $result->user_id;
            if ($user_type == '1') {
                $data = array(
                    'user_id' => $user_id, //email-id
                    'user_type' => $user_type,
                );
                return $data;
            } elseif ($user_type == '2') {
                $data = array(
                    'user_id' => $user_id, //email-id
                    'user_type' => $user_type,
                );
                return $data;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

}
