<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class login_model extends CI_Model {

    public function login_validation($user_id, $pass) {
        $q = $this->db->query("SELECT * from customer_header_all where customer_email_id='$user_id' AND password='$pass'");
        if ($q->num_rows() == 1) {
            $result = $q->row();
            $customer_email_id = $result->customer_email_id;
            $customer_id = $result->customer_id;
            $user_type = $result->user_type;
            if ($user_type == '1') {
                $data = array(
                    'customer_email_id' => $customer_email_id, //email-id
                    'user_type' => $user_type,
                );
                return $data;
            } elseif ($user_type == '2') {
                $data = array(
                    'customer_email_id' => $customer_email_id, //email-id
                    'user_type' => $user_type,
                    'customer_id' => $customer_id,
                );
                return $data;
            }elseif ($user_type == '3') {
                $data = array(
                    'customer_email_id' => $customer_email_id, //email-id
                    'user_type' => $user_type,
                    'customer_id' => $customer_id,
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
