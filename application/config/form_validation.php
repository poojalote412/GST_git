<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'f_login' => array(
        array(
            'field' => 'user_id',
            'label' => 'Email Id',
            'rules' => 'required|min_length[3]|max_length[50]|xss_clean|trim|htmlspecialchars|encode_php_tags',
        ),
        array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[3]|max_length[50]|xss_clean|htmlspecialchars|encode_php_tags',
        )
    ),
);
