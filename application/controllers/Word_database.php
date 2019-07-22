 <?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Word_database  extends CI_Controller {

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
    
    public function word_to_database(){
//        $string = read_file('test11.txt');
//    echo $string;
        
       $file_ex1 = $_FILES['file_ex']['name'];
     
        var_dump($file_ex1);
       
exit();
//       echo 
        exit;
//        $file_ex = $this->input->post("file_ex");
//        var_dump($file_ex);
//       exit;
        if($file_ex1)
  {
      if(($fh = fopen($file_ex1, 'r')) !== false ) 
      {
                $headers = fread($fh, 0xA00);
//                1 = (ord(n)*1) ; 
         $n1 = ( ord($headers[0x21C]) - 1 );
//         var_dump($n1);
                  if($file_ex1){
                 $response['message'] = 'success';
                $response['code'] = 200;
                $response['status'] = true;
                  }
         else{
                      
                 $response['message'] = 'No data to display';
                $response['code'] = 204;
                $response['status'] = false;
            }echo json_encode($response);
    }
    }


}
}
?>