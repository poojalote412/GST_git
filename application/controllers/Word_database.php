<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Word_database extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('Account_model');
        $this->load->library('excel');
//         $this->load->helper('file');    
    }

    public function index_admin() {
//        $data['result'] = $result;
        $this->load->view('admin/word_database');
    }

    public function word_to_databasea() {
//        $string = read_file('test11.txt');
//    echo $string;

        echo $file_ex = $_FILES['file_ex']['name'];
//         $text = file_get_contents($file_ex);
//        echo $file_ex1;
//        var_dump($file_ex1);
//        $config['allowed_types'] = 'gif|jpg|png|jpeg|jpe|pdf|doc|docx|rtf|text|txt';
//        $config['max_size'] = '4096';
//        $config['max_width'] = '1024';
//        $config['max_height'] = '1024';
//        $config['encrypt_name'] = true;
//
//        $this->load->library('upload', $config);
//         $file_name = $this->upload->data('file_ex'); 
//
//     print_r($file_name);
        $MyFile = file_get_contents(base_url() . "images/text.rtf");

// $myFile1=readfile(base_url()."images/text.rtf");
        $myFile1 = readfile($MyFile);
// echo $myFile1;
        $obj = utf8_encode($MyFile);
        $obj1 = json_encode($myFile1);
        print '<pre>' . print_r($obj) . '</pre>';
        exit();
//       echo 
        exit;
//        $file_ex = $this->input->post("file_ex");
//        var_dump($file_ex);
//       exit;
//        if($file_ex1)
//  {
//      if(($fh = fopen($file_ex1, 'r')) !== false ) 
//      {
//                $headers = fread($fh, 0xA00);
////                1 = (ord(n)*1) ; 
//         $n1 = ( ord($headers[0x21C]) - 1 );
////         var_dump($n1);
//                  if($file_ex1){
//                 $response['message'] = 'success';
//                $response['code'] = 200;
//                $response['status'] = true;
//                  }
//         else{
//                      
//                 $response['message'] = 'No data to display';
//                $response['code'] = 204;
//                $response['status'] = false;
//            }echo json_encode($response);
//    }
//    }
    }

    public function word_to_database() {
        $file_ex1 = $_FILES["file_ex"]["name"];

//        $name = $_FILES['file']['name'];
//        $temp_name = $_FILES['file']['tmp_name'];
        echo $file_ex1;
        if ($file_ex1 != "") {
            //for email sent
//           $email= $this->Gst_email_file_model->GstcustomersendEmail($customer_id);
            $path = $_FILES["file_ex1"]["tmp_name"];
            $file_ex_summary = $this->test($file_ex);
        } else {
            
        }
    }

    function test($file_ex) {
        // Read the data from the input file.
        $text = file_get_contents($file_ex);
        echo $text;
    }

}

?>