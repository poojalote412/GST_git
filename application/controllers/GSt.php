<?php

class Gst extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('customer_model');
        $this->db2 = $this->load->database('db2', TRUE);
//        $this->db3 = $this->load->database('db3', TRUE);
        $this->load->library('excel');
    }

//Function for upload gst files

    public function edit_customer_file_details_view($cust_id) {
        $data['prev_title'] = "";
        $data['page_title'] = "Edit Customer";
        $result1 = $this->customer_model->get_firm_id();
        if ($result1 !== false) {
            $firm_id = $result1['firm_id'];
        }
        $query = $this->db->query("SELECT `firm_logo`,`user_name` FROM `user_header_all` where `firm_id`= '$firm_id'");
        if ($query->num_rows() > 0) {

            $record = $query->row();
            $firm_logo = $record->firm_logo;
            $firm_name = $record->user_name;
            $user_name = $record->user_name;
            if ($firm_logo == "" && $firm_name == "" && $user_name == "") {

                $data['logo'] = "";
                $data['firm_name_nav'] = "";
                $data['user_name'] = "";
            } else {
                $data['logo'] = $firm_logo;
                $data['firm_name_nav'] = $firm_name;
                $data['user_name'] = $user_name;
            }
        } else {
            $data['logo'] = "";
            $data['firm_name_nav'] = "";
        }
        $record = $this->customer_model->get_customer_details($cust_id);
        $record2 = $this->customer_model->get_customer_contact_details($cust_id);


        if ($record !== false && $record2 !== false) {
            $data['record'] = $record->row();
            $data['contact_record'] = $record2->result();
            $response['message'] = 'success';
            $response['code'] = 200;
            $response['status'] = true;
        } else {
            $response['message'] = 'No data to display';
            $response['code'] = 204;
            $response['status'] = false;
        }
        $this->load->view('client_admin/edit_customer_files', $data);
    }

//Function for storing all excel files data

    public function import_tax_liability() {
        $customer_id = $this->input->post('cust_id');
        $values = 1;
        $vall = 1;
        $compare_val = 1;
        $value_insert_nrc = 1;
        $value_insert = 1;
        $value_insert_p_match = 1;
        $sales_year_value = 1;
        $without_invoice = 1;
        $invoice_ammend = 1;
        $return_filled_GSTR1 = 1;
        $function_monthly_file = 0;
        $function_3boffset_file = 0;
        $function_compare_summary = 0;
        $function_reconcillation_summary = 0;
        $function_state_wise_summary = 0;
        $function_without_invoice_summary = 0;
        $function_invoice_ammend_summary = 0;
        $function_return_filled_gstr1 = 0;
        $monthly_file = $_FILES['file_ex1']['name'];
        $threeb_offset_file = $_FILES['file_ex2']['name'];
        $comparison_file = $_FILES['file_ex_compare']['name'];
        $reconcillation_file = $_FILES['file_ex_reconcill']['name'];
        $state_wise_file = $_FILES['file_ex_state_wise']['name'];
        $without_invoice_file = $_FILES['file_ex_withot_invoice']['name'];
        $invoice_ammend_file = $_FILES['file_ex_invoice_amend']['name'];
        $return_filled_gstr1_file = $_FILES['file_word_database']['name'];
//        $word_to_pdf_file = $_FILES['word_to_pdf_conversion']['name'];

        $insert_id = $this->generate_insert_id();

        if ($monthly_file != "") {
//           $email= $this->Gst_email_file_model->GstcustomersendEmail($customer_id);
            $path = $_FILES["file_ex1"]["tmp_name"];
            $function_monthly_file = $this->monthly_file_function($path, $insert_id, $customer_id, $vall);
        } else {
            
        }
        if ($threeb_offset_file != "") {
            $path1 = $_FILES["file_ex2"]["tmp_name"];
            $function_3boffset_file = $this->tboffset_file_function($path1, $insert_id, $customer_id, $values);
        } else {
            
        }
        if ($comparison_file != "") {
            $path2 = $_FILES["file_ex_compare"]["tmp_name"];
            $function_compare_summary = $this->compare_summary_function($path2, $compare_val);
        } else {
            
        }

        if ($reconcillation_file != "") {
            $path3 = $_FILES["file_ex_reconcill"]["tmp_name"];
            $function_reconcillation_summary = $this->reconcillation_summary_function($path3, $value_insert_nrc, $value_insert, $value_insert_p_match);
            $value_insert = $function_reconcillation_summary[0];
            $value_insert_nrc = $function_reconcillation_summary[1];
            $value_insert_p_match = $function_reconcillation_summary[2];
        } else {
            
        }

        if ($state_wise_file != "") {
            $path4 = $_FILES["file_ex_state_wise"]["tmp_name"];

            $function_state_wise_summary = $this->state_wise_summary_function($path4, $sales_year_value);
        } else {
            
        }

        if ($without_invoice_file != "") {
            $path5 = $_FILES["file_ex_withot_invoice"]["tmp_name"];

            $function_without_invoice_summary = $this->without_invoice_summary_function($path5, $without_invoice);
        } else {
            
        }

        if ($invoice_ammend_file != "") {
            $path6 = $_FILES["file_ex_invoice_amend"]["tmp_name"];

            $function_invoice_ammend_summary = $this->invoice_ammend_summary_function($path6, $invoice_ammend);
        } else {
            
        }

        if ($return_filled_gstr1_file != "") {
            $path7 = $_FILES["file_word_database"]["tmp_name"];

            $function_return_filled_gstr1 = $this->return_filled_summary_function($path7, $return_filled_GSTR1);
        } else {
            
        }

        if ($function_monthly_file > 1 || $function_3boffset_file > 1 || $function_compare_summary > 1 || $value_insert > 1 || $value_insert_nrc > 1 || $value_insert_p_match > 1 || $function_state_wise_summary > 1 || $function_without_invoice_summary > 1 || $function_invoice_ammend_summary > 1 || $function_return_filled_gstr1 > 1) {

            $insert_header_function = $this->insert_header_function($monthly_file, $threeb_offset_file, $comparison_file, $reconcillation_file, $state_wise_file, $without_invoice_file, $invoice_ammend_file, $return_filled_gstr1_file);

            $response['message'] = "success";
            $response['status'] = true;
            $response['code'] = 200;
        } else {
            $response['message'] = "";
            $response['status'] = FALSE;
            $response['code'] = 204;
        }
        echo json_encode($response);
    }

//Function for sales consolidated monthly file

    public function monthly_file_function($path, $insert_id, $customer_id, $vall) {
        $object = PHPExcel_IOFactory::load($path);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $customer_file_years = $this->input->post('customer_file_years');
        $x1 = "G";
        $s = 1;
        $months = array();
//loop to get month data
        for ($i = 1; $i <= $highestRow; $i++) {
            if ($object->getActiveSheet()->getCell('A' . $i)->getValue() == "Goods") {
                $s++;
                while (($object->getActiveSheet()->getCell($x1 . $i)->getValue() !== "Grand Tatal") && ($object->getActiveSheet()->getCell($x1 . $i)->getValue() !== "Grand Total")) {
                    $months[] = $object->getActiveSheet()->getCell($x1 . $i)->getValue();
                    $x1++;
                }
            }
            if ($s > 1) {
                break;
            }
        }

        if (in_array(null, $months, true)) {
            $month_data = $this->get_months($months);
        } else {
            $month_data = $months;
        }

        if (in_array(null, $month_data, true)) {
            $month_data = $this->get_months2($months);
        }
        $value11 = 0;
        $anew = 0;
        $anew1 = 0;
        $anew2 = 0;
        $anewk = 0;
        $anewk1 = 0;
        $anewk2 = 0;


        $get_total_non_gst = "";
        $total_taxable_data_interstate = "";
        $total_tax_data_interstate = "";
        $total_taxable_data_intrastate = "";
        $total_tax_data_intrastate = "";
        $get_SUB_total_non_gst = "";
        $get_SUB_total_exempt = "";
        $total_debit_data = "";
        $total_debit_tax_data = "";
        $total_credit_data = "";
        $total_credit_tax_data = "";
        $total_taxable_advance_no_invoice = "";
        $total_tax_advance_no_invoice = "";
        $total_taxable_advance_invoice = "";
        $total_tax_advance_invoice = "";
        $advance_invoice_not_issue_b2b = "";
        $advance_invoice_issue_b2b = "";
        $total_taxable_data_gst_export = "";
        $total_tax_data_gst_export = "";
        $total_non_gst_export = "";

        $credit_b2b = "";
        $debit_b2b = "";
        $intrastate_b2c = "";
        $intrastate_b2b = "";
        $total_b2c_interstate = "";
        $total_b2b_interstate = "";
        $get_credit_b2c = "";
        $get_debit_b2c = "";
        $adv_no_invoice_b2c = "";
        $adv_invoice_b2c = "";
        $nil_rated_value = "";
        $abcl = $object->getActiveSheet()->getCell('A' . 3)->getValue();
//        echo $abcl;
        $aa = (explode(" ", $abcl));
        $b = substr($customer_file_years, 7);
        $a = substr($customer_file_years, 0, -4);
        $x = $a . $b;

//        $monthly_file = $object->getActiveSheet()->getCell('A' . 2)->getValue();
//        $dddd = substr($monthly_file, 0, -1);
//        echo $dddd;
//        if ($dddd) {
//            echo"yes";
//        } else {
//            echo"error";
//        }
//        exit;

        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        }
//        } else if ($dddd) {
//            $response['id'] = 'file_ex1';
//            $response['error'] = 'You choose incorerct file of Consolidated sales monthly';
//            echo json_encode($response);
//            exit;
//        } 
        else if ($aa[2] == $x) {
            for ($i = 1; $i <= $highestRow; $i++) {
                $a_new2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();

                if (stripos($a_new2, " Total value of supplies on which GST paid (intra-State Supplies [Other than Deemed Export])") == TRUE) {
                    $anew = 1;
                    $anew1 = 1;
                    $anew2 = 1;
                } else if (stripos($a_new2, "Value of Other Supplies on which no GST paid") == TRUE) {
                    $anew1 = 2;
                    $anew = 2;
                } else if (stripos($a_new2, " Total value of supplies on which GST paid (Inter-State Supplies [Other than SEZ & Deemed Export])") == TRUE) {
                    $anew = 3;
                    $anewk = 3;
                } else if (stripos($a_new2, " Total value of Adavnce Received but invoice not issued in same period") == TRUE) {
                    $anew = 4;
                    $highestColumn_cr4 = $worksheet->getHighestColumn($i);
                    for ($k = 0; $k < 4; $k++) {
                        $a11 = strlen($highestColumn_cr4);
                        $index1 = strlen($highestColumn_cr4) - 1;
                        $ord1 = ord($highestColumn_cr4[$index1]);
                        $a1 = substr($highestColumn_cr4, 0, 1);
                        $a2 = substr($highestColumn_cr4, 1);
                        if ($a1 != $a2 and $a2 == "A") {
                            $ord = ord($highestColumn_cr4[1]);
                            $index = 1;
                            $o1 = ord($a1);
                            $o2 = chr($o1 - 1);
                            $highestColumn_row_pp = $o2 . "Z";
                        } else {
                            $highestColumn_row_pp = $this->getAlpha($highestColumn_cr4, $ord1, $a11, $index1);
                        }
                        $highestColumn_cr4 = $highestColumn_row_pp;
                    }
                } else if (stripos($a_new2, " Adavnce Received in earlier period but invoice issued in current period") == TRUE) {
                    $anew = 5;
                    $highestColumn_cr4 = $worksheet->getHighestColumn($i);
                    for ($k = 0; $k < 4; $k++) {
                        $a11 = strlen($highestColumn_cr4);
                        $index1 = strlen($highestColumn_cr4) - 1;
                        $ord1 = ord($highestColumn_cr4[$index1]);
                        $a1 = substr($highestColumn_cr4, 0, 1);
                        $a2 = substr($highestColumn_cr4, 1);
                        if ($a1 != $a2 and $a2 == "A") {
                            $ord = ord($highestColumn_cr4[1]);
                            $index = 1;
                            $o1 = ord($a1);
                            $o2 = chr($o1 - 1);
                            $highestColumn_row_pp = $o2 . "Z";
                        } else {
                            $highestColumn_row_pp = $this->getAlpha($highestColumn_cr4, $ord1, $a11, $index1);
                        }
                        $highestColumn_cr4 = $highestColumn_row_pp;
                    }
                } else if (stripos($a_new2, " Total value of supplies on which GST Paid (Exports)") == TRUE) {
                    $anew = 6;
                } else if (stripos($a_new2, " Total value of supplies on which no GST Paid (Exports)") == TRUE) {
                    $anew = 7;
                } else if (stripos($a_new2, " Value of Other Supplies on which no GST paid") == TRUE) {
                    $anew = 8;
                }


//for get value between credit note and debit note
                $aa2 = $object->getActiveSheet()->getCell('A' . $i)->getValue();

                if (stripos($aa2, "Cr Note Details")) {
                    $value11 = 1;
                } else if (stripos($aa2, "Dr Note Details")) {
                    $value11 = 2;
                }

//code for monthly data of total taxable and total tax value start
                $row_prev = $i - 1;
                if ($anew == 3) {

                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (B2CS)") {

                        $get_inter_state_total = $this->get_inter_state_total_fun1($x1, $i, $object); //function to get interstate data
                        $total_taxable_data_interstate = $get_inter_state_total[0]; //taxable value data
                        $total_tax_data_interstate = $get_inter_state_total[1]; //tax value data
//                        var_dump($total_tax_data_interstate);
                    }
                } elseif ($anew2 == 1) {
                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (B2CS)") {
                        $highest_value = $worksheet->getHighestColumn($i);
                        $get_intra_state_total = $this->get_intra_state_total($x1, $i, $object); //function to get intrastate data
                        $total_taxable_data_intrastate = $get_intra_state_total[0]; //taxable value data
                        $total_tax_data_intrastate = $get_intra_state_total[1]; //tax value data
                    } else {
                        
                    }
                } if ($anew == 4) {
                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (B2B)") {
                        $prev = $i - 1;
                        $advance_invoice_not_issue_b2b = $this->advance_invoice_not_issue_b2b_fun($highestColumn_cr4, $prev, $object); //function to get advance and invoice not issue b2b data
                        $advance_invoice_not_issue = $this->advance_invoice_not_issue_fun($highestColumn_cr4, $i, $object); //function to get advance and invoice not issue data
                        $total_taxable_advance_no_invoice = $advance_invoice_not_issue[0];
                        $total_tax_advance_no_invoice = $advance_invoice_not_issue[1];
                    } else {
                        
                    }
                } elseif ($anew == 5) {
                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (B2B)") {
                        $prev = $i - 1;
                        $advance_invoice_issue_b2b = $this->advance_invoice_not_issue_b2b_fun($highestColumn_cr4, $prev, $object); //function to get advance and invoice not issue b2b data
                        $advance_invoice_issue = $this->advance_invoice_not_issue_fun($highestColumn_cr4, $i, $object); //function to get advance and invoice not issue data
                        $total_taxable_advance_invoice = $advance_invoice_issue[0];
                        $total_tax_advance_invoice = $advance_invoice_issue[1];
                    } else {
                        
                    }
                } elseif ($anew == 6) {
                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total" && $object->getActiveSheet()->getCell('B' . $row_prev)->getValue() == "Sub Total (EXP)") {
                        $get_inter_state_total = $this->get_inter_state_total_fun1($x1, $i, $object); //function to get Total value of supplies on which GST Paid (Exports)
                        $total_taxable_data_gst_export = $get_inter_state_total[0]; //taxable value data
                        $total_tax_data_gst_export = $get_inter_state_total[1]; //tax value data
                    } else {
                        
                    }
                } elseif ($anew == 7) {
                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total") { //Total value of supplies on which no GST Paid (Exports)
                        $highestColumn_row_ng = $worksheet->getHighestColumn($i);
                        $char = 'G';
                        $total_non_gst_export = $this->get_no_gst_data($highestColumn_row_ng, $char, $object, $i); //function to get non gst data
                    } else {
                        
                    }
                } elseif ($anew == 8) {
                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total") { // no gst data
                        $highestColumn_row_ng = $worksheet->getHighestColumn($i);
                        $char = 'G';
                        $get_total_non_gst = $this->get_no_gst_data($highestColumn_row_ng, $char, $object, $i); //function to get non gst data
                    } else {
                        
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (NON-GST)") { // Sub Total (NON-GST) DATA
                    $highestColumn_row_sbng = $worksheet->getHighestColumn($i);
                    $get_SUB_total_non_gst = $this->sub_total_non_gst($highestColumn_row_sbng, $object, $i);
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (EXEMPTED)") { // Sub Total (EXEMPTED) DATA
                    $highestColumn_row_sbng = $worksheet->getHighestColumn($i);
                    $get_SUB_total_exempt = $this->sub_total_non_gst($highestColumn_row_sbng, $object, $i);
                } elseif (stripos($object->getActiveSheet()->getCell('A' . $i)->getValue(), "Dr Note Details") == TRUE) {  // debit note data
                    $get_debit_note_total = $this->get_debit_data($i, $object, $highestRow, $worksheet);
                    $total_debit_data = $get_debit_note_total[0]; //taxable value data of debit note
                    $total_debit_tax_data = $get_debit_note_total[1]; //tax value data of debit note
                } elseif ((stripos($object->getActiveSheet()->getCell('A' . $i)->getValue(), "Cr Note Details") == TRUE)) {  //credit note data
                    $get_credit_note_total = $this->get_credit_data($i, $object, $highestRow, $worksheet);
                    $total_credit_data = $get_credit_note_total[0]; //taxable value data of credit note
                    $total_credit_tax_data = $get_credit_note_total[1]; //tax value data of credit note
                } else {
                    
                }

//code for monthly data of total taxable and total tax value end
//code for monthly B2B and B2Cs values start

                if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2B)") {
// intra state b2b values
                    if ($anew == 1) {
                        $intrastate_b2b = $this->intrastate_b2b_fun($worksheet, $object, $i); // intra state b2b values
                    } elseif ($value11 == 1) {
                        $credit_b2b = $this->credit_b2b_fun($worksheet, $object, $i); // Credit b2b values
                    } else if ($anew == 3) {
                        $get_inter_state_total_b2b = $this->get_inter_state_total_fun($x1, $i, $object); //function to get interstate data
                        $total_b2b_interstate = $get_inter_state_total_b2b[0]; //B2B intersate data 
                    } else if ($value11 == 2) {
                        $debit_b2b = $this->debit_b2b_fun($worksheet, $object, $i); //Debit b2b values
                    } else {
                        
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (NIL RATED)") {
                    if ($anew == 2) {
                        $highestColumn_row_sbng = $worksheet->getHighestColumn($i);
                        $nil_rated_value = $this->sub_total_non_gst($highestColumn_row_sbng, $object, $i); // Nill Rated b2b values
                    } else {
                        
                    }
                } elseif ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Sub Total (B2CS)") { //interstate
                    if ($anew == 1) {
                        $intrastate_b2c = $this->intrastate_b2c_fun($worksheet, $object, $i, $x1); // intra state b2c values
                    } else if ($anew == 3) {
                        $get_inter_state_total_b2c = $this->get_inter_state_total_fun($x1, $i, $object); //function to get interstate data
                        $total_b2c_interstate = $get_inter_state_total_b2c[0]; //B2C intersate data 
                    } elseif ($anew == 4) {
                        $adv_no_invoice_b2c = $this->intrastate_b2c_fun($worksheet, $object, $i, $x1); // advance but not invoice b2c values
                    } elseif ($anew == 5) {
                        $adv_invoice_b2c = $this->intrastate_b2c_fun($worksheet, $object, $i, $x1); // advance but  invoice b2c values
                    } else {
                        
                    }
                } elseif (stripos($object->getActiveSheet()->getCell('B' . $i)->getValue(), "Cr Note Details") == TRUE) {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $get_credit_b2c = $this->get_credit_debit_b2c($j, $worksheet, $object); //credit b2c data
                        }
                    }
                } elseif (stripos($object->getActiveSheet()->getCell('B' . $i)->getValue(), "Dr Note Details") == TRUE) {
                    for ($j = $i; $j <= $highestRow; $j++) {
                        if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Sub Total (B2CS)") {
                            $get_debit_b2c = $this->get_credit_debit_b2c($j, $worksheet, $object); //debit b2c data
                        }
                    }
                } else {
                    
                }

//code for monthly B2B and B2Cs values end
            }
        } else {
            $response['id'] = 'file_ex1';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
            echo json_encode($response);
            exit;
        }

//insert data into database
        $month_data_arr = $month_data; //array of month data
        $count = count($month_data_arr);
        $customer_year = $this->input->post('customer_file_years');
//$cusomer_id = 'cust_1001';
//            $year_id = 'year_1001';
//            $year_id = $customer_id . "_" . $customer_year;
        $query = $this->db2->query("SELECT * FROM `monthly_summary_all` where customer_id='$customer_id'");
        if ($this->db2->affected_rows() > 0) {
            $monthly_history = $this->insert_monthly_summary_history($customer_id);
            if ($monthly_history == true) {
                for ($t = 0; $t < $count; $t++) {
                    if ($get_debit_b2c == "" or $get_debit_b2c == NULL) {
                        $get_debit_b2c1 = array();
                        $get_debit_b2c1[$t] = 0; //array of inter state supply
                    } else {
                        $get_debit_b2c1 = $get_debit_b2c; //array of inter state supply
                    }if ($get_credit_b2c == "" or $get_credit_b2c == NULL) {
                        $get_credit_b2c1 = array();
                        $get_credit_b2c1[$t] = 0; //array of inter state supply
                    } else {
                        $get_credit_b2c1 = $get_credit_b2c; //array of inter state supply
                    }if ($total_taxable_data_interstate == "" or $total_taxable_data_interstate == NULL) {
                        $total_taxable_data_interstate1 = array();
                        $total_taxable_data_interstate1[$t] = 0; //array of inter state supply
                    } else {
                        $total_taxable_data_interstate1 = $total_taxable_data_interstate; //array of inter state supply
                    }if ($total_taxable_data_intrastate == "" or $total_taxable_data_intrastate == NULL) {
                        $total_taxable_data_intrastate1 = array();
                        $total_taxable_data_intrastate1[$t] = 0; //array of inter state supply
                    } else {
                        $total_taxable_data_intrastate1 = $total_taxable_data_intrastate; //array of inter state supply
                    }if ($get_total_non_gst == "" or $get_total_non_gst == NULL) {
                        $get_total_non_gst1 = array();
                        $get_total_non_gst1[$t] = 0; //array of inter state supply
                    } else {
                        $get_total_non_gst1 = $get_total_non_gst; //array of inter state supply
                    }if ($total_debit_data == "" or $total_debit_data == NULL) {
                        $total_debit_data1 = array();
                        $total_debit_data1[$t] = 0; //array of inter state supply
                    } else {
                        $total_debit_data1 = $total_debit_data; //array of inter state supply
                    }if ($total_credit_data == "" or $total_credit_data == NULL) {
                        $total_credit_data1 = array();
                        $total_credit_data1[$t] = 0; //array of inter state supply
                    } else {
                        $total_credit_data1 = $total_credit_data; //array of inter state supply
                    }if ($get_SUB_total_non_gst == "" or $get_SUB_total_non_gst == NULL) {
                        $get_SUB_total_non_gst1 = array();
                        $get_SUB_total_non_gst1[$t] = 0; //array of inter state supply
                    } else {
                        $get_SUB_total_non_gst1 = $get_SUB_total_non_gst; //array of inter state supply
                    }if ($get_SUB_total_exempt == "" or $get_SUB_total_exempt == NULL) {
                        $get_SUB_total_exempt1 = array();
                        $get_SUB_total_exempt1[$t] = 0; //array of inter state supply
                    } else {
                        $get_SUB_total_exempt1 = $get_SUB_total_exempt; //array of inter state supply
                    }if ($total_tax_data_interstate == "" or $total_tax_data_interstate == NULL) {
                        $total_tax_data_interstate1 = array();
                        $total_tax_data_interstate1[$t] = 0; //array of inter state supply
                    } else {
                        $total_tax_data_interstate1 = $total_tax_data_interstate; //array of inter state supply
                    }if ($total_tax_data_intrastate == "" or $total_tax_data_intrastate === NULL) {
                        $total_tax_data_intrastate1 = array();
                        $total_tax_data_intrastate1[$t] = 0; //array of inter state supply
                    } else {
                        $total_tax_data_intrastate1 = $total_tax_data_intrastate; //array of inter state supply
                    }if ($total_debit_tax_data == "" or $total_debit_tax_data == NULL) {
                        $total_debit_tax_data1 = array();
                        $total_debit_tax_data1[$t] = 0; //array of inter state supply
                    } else {
                        $total_debit_tax_data1 = $total_debit_tax_data; //array of inter state supply
                    }if ($total_credit_tax_data == "" or $total_credit_tax_data == NULL) {
                        $total_credit_tax_data1 = array();
                        $total_credit_tax_data1[$t] = 0; //array of inter state supply
                    } else {
                        $total_credit_tax_data1 = $total_credit_tax_data; //array of inter state supply
                    }if ($total_b2b_interstate == "" or $total_b2b_interstate == NULL) {
                        $total_b2b_interstate1 = array();
                        $total_b2b_interstate1[$t] = 0; //array of inter state supply
                    } else {
                        $total_b2b_interstate1 = $total_b2b_interstate; //array of inter state supply
                    }if ($intrastate_b2b == "" or $intrastate_b2b == NULL) {
                        $intrastate_b2b1 = array();
                        $intrastate_b2b1[$t] = 0; //array of inter state supply
                    } else {
                        $intrastate_b2b1 = $intrastate_b2b; //array of inter state supply
                    }if ($total_b2c_interstate == "" or $total_b2c_interstate == NULL) {
                        $total_b2c_interstate1 = array();
                        $total_b2c_interstate1[$t] = 0; //array of inter state supply
                    } else {
                        $total_b2c_interstate1 = $total_b2c_interstate; //array of inter state supply
                    }if ($intrastate_b2c == "" or $intrastate_b2c == NULL) {
                        $intrastate_b2c1 = array();
                        $intrastate_b2c1[$t] = 0; //array of inter state supply
                    } else {
                        $intrastate_b2c1 = $intrastate_b2c; //array of inter state supply
                    }if ($credit_b2b == "" or $credit_b2b == NULL) {
                        $credit_b2b1 = array();
                        $credit_b2b1[$t] = 0; //array of inter state supply
                    } else {
                        $credit_b2b1 = $credit_b2b; //array of inter state supply
                    }if ($debit_b2b == "" or $debit_b2b == NULL) {
                        $debit_b2b1 = array();
                        $debit_b2b1[$t] = 0; //array of inter state supply
                    } else {
                        $debit_b2b1 = $debit_b2b; //array of inter state supply
                    }if ($total_taxable_advance_no_invoice == "" or $total_taxable_advance_no_invoice == NULL) {
                        $total_taxable_advance_no_invoice1 = array();
                        $total_taxable_advance_no_invoice1[$t] = 0; //array of inter state supply
                    } else {
                        $total_taxable_advance_no_invoice1 = $total_taxable_advance_no_invoice; //array of inter state supply
                    }if ($total_tax_advance_no_invoice == "" or $total_tax_advance_no_invoice == NULL) {
                        $total_tax_advance_no_invoice1 = array();
                        $total_tax_advance_no_invoice1[$t] = 0; //array of inter state supply
                    } else {
                        $total_tax_advance_no_invoice1 = $total_tax_advance_no_invoice; //array of inter state supply
                    }if ($total_taxable_advance_invoice == "" or $total_taxable_advance_invoice == NULL) {
                        $total_taxable_advance_invoice1 = array();
                        $total_taxable_advance_invoice1[$t] = 0; //array of inter state supply
                    } else {
                        $total_taxable_advance_invoice1 = $total_taxable_advance_invoice; //array of inter state supply
                    }if ($total_tax_advance_invoice == "" or $total_tax_advance_invoice == NULL) {
                        $total_tax_advance_invoice1 = array();
                        $total_tax_advance_invoice1[$t] = 0; //array of inter state supply
                    } else {
                        $total_tax_advance_invoice1 = $total_tax_advance_invoice; //array of inter state supply
                    }if ($advance_invoice_not_issue_b2b == "" or $advance_invoice_not_issue_b2b == NULL) {
                        $advance_invoice_not_issue_b2b1 = array();
                        $advance_invoice_not_issue_b2b1[$t] = 0; //array of inter state supply
                    } else {
                        $advance_invoice_not_issue_b2b1 = $advance_invoice_not_issue_b2b; //array of inter state supply
                    }if ($advance_invoice_issue_b2b == "" or $advance_invoice_issue_b2b == NULL) {
                        $advance_invoice_issue_b2b1 = array();
                        $advance_invoice_issue_b2b1[$t] = 0; //array of inter state supply
                    } else {
                        $advance_invoice_issue_b2b1 = $advance_invoice_issue_b2b; //array of inter state supply
                    }if ($total_taxable_data_gst_export == "" or $total_taxable_data_gst_export == NULL) {
                        $total_taxable_data_gst_export1 = array();
                        $total_taxable_data_gst_export1[$t] = 0; //array of inter state supply
                    } else {
                        $total_taxable_data_gst_export1 = $total_taxable_data_gst_export; //array of inter state supply
                    }if ($total_tax_data_gst_export == "" or $total_tax_data_gst_export == NULL) {
                        $total_tax_data_gst_export1 = array();
                        $total_tax_data_gst_export1[$t] = 0; //array of inter state supply
                    } else {
                        $total_tax_data_gst_export1 = $total_tax_data_gst_export; //array of inter state supply
                    }if ($total_non_gst_export == "" or $total_non_gst_export == NULL) {
                        $total_non_gst_export1 = array();
                        $total_non_gst_export1[$t] = 0; //array of inter state supply
                    } else {
                        $total_non_gst_export1 = $total_non_gst_export; //array of inter state supply
                    }
                    if ($adv_no_invoice_b2c == "" or $adv_no_invoice_b2c == NULL) {
                        $adv_no_invoice_b2c1 = array();
                        $adv_no_invoice_b2c1[$t] = 0; //array of inter state supply
                    } else {
                        $adv_no_invoice_b2c1 = $adv_no_invoice_b2c; //array of inter state supply
                    }
                    if ($adv_invoice_b2c == "" or $adv_invoice_b2c == NULL) {
                        $adv_invoice_b2c1 = array();
                        $adv_invoice_b2c1[$t] = 0; //array of inter state supply
                    } else {
                        $adv_invoice_b2c1 = $adv_invoice_b2c; //array of inter state supply
                    }
                    if ($nil_rated_value == "" or $nil_rated_value == NULL) {
                        $nil_rated_value1 = array();
                        $nil_rated_value1[$t] = 0; //array of inter state supply
                    } else {
                        $nil_rated_value1 = $nil_rated_value; //array of inter state supply
                    }
                    $insert_id = $this->generate_insert_id();



                    $quer = $this->db2->query("insert into monthly_summary_all (`customer_id`,`insert_id`,`month`,`inter_state_supply`,`intra_state_supply`,`no_gst_paid_supply`,`debit_value`,"
                            . "`credit_value`,`sub_total_non_gst`,`sub_total_exempt`,`tax_inter_state`,`tax_intra_state`,`tax_debit`,`tax_credit`,`interstate_b2b`,`intrastate_b2b`,`interstate_b2c`,"
                            . "`intrastate_b2c`,`credit_b2b`,`credit_b2c`,`debit_b2b`,`debit_b2c`,`total_taxable_advance_no_invoice`,`total_tax_advance_no_invoice`,`total_taxable_advance_invoice`"
                            . ",`total_tax_advance_invoice`,`advance_invoice_not_issue_b2b`,`advance_invoice_issue_b2b`,`total_taxable_data_gst_export`,`total_tax_data_gst_export`,"
                            . "`total_non_gst_export`,`advance_invoice_not_issue_b2c`,`advance_invoice_issue_b2c`,`sub_total_nil_rated`)"
                            . " values ('$customer_id','$insert_id','$month_data_arr[$t]','$total_taxable_data_interstate1[$t]','$total_taxable_data_intrastate1[$t]','$get_total_non_gst1[$t]',"
                            . "'$total_debit_data1[$t]','$total_credit_data1[$t]','$get_SUB_total_non_gst1[$t]','$get_SUB_total_exempt1[$t]','$total_tax_data_interstate1[$t]',"
                            . "'$total_tax_data_intrastate1[$t]','$total_debit_tax_data1[$t]','$total_credit_tax_data1[$t]','$total_b2b_interstate1[$t]','$intrastate_b2b1[$t]'"
                            . ",'$total_b2c_interstate1[$t]','$intrastate_b2c1[$t]','$credit_b2b1[$t]','$get_credit_b2c1[$t]','$debit_b2b1[$t]','$get_debit_b2c1[$t]','$total_taxable_advance_no_invoice1[$t]',"
                            . "'$total_tax_advance_no_invoice1[$t]','$total_taxable_advance_invoice1[$t]','$total_tax_advance_invoice1[$t]','$advance_invoice_not_issue_b2b1[$t]','$advance_invoice_issue_b2b1[$t]',"
                            . "'$total_taxable_data_gst_export1[$t]','$total_tax_data_gst_export1[$t]','$total_non_gst_export1[$t]','$adv_no_invoice_b2c1[$t]','$adv_invoice_b2c1[$t]','$nil_rated_value1[$t]') ");
                    if ($this->db2->affected_rows() > 0) {
                        $vall++;
                    }
                }
            }
        } else {
            for ($t = 0; $t < $count; $t++) {
                if ($get_debit_b2c == "" or $get_debit_b2c == NULL) {
                    $get_debit_b2c1 = array();
                    $get_debit_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $get_debit_b2c1 = $get_debit_b2c; //array of inter state supply
                }if ($get_credit_b2c == "" or $get_credit_b2c == NULL) {
                    $get_credit_b2c1 = array();
                    $get_credit_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $get_credit_b2c1 = $get_credit_b2c; //array of inter state supply
                }if ($total_taxable_data_interstate == "" or $total_taxable_data_interstate == NULL) {
                    $total_taxable_data_interstate1 = array();
                    $total_taxable_data_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_taxable_data_interstate1 = $total_taxable_data_interstate; //array of inter state supply
                }if ($total_taxable_data_intrastate == "" or $total_taxable_data_intrastate == NULL) {
                    $total_taxable_data_intrastate1 = array();
                    $total_taxable_data_intrastate1[$t] = 0; //array of inter state supply
                } else {
                    $total_taxable_data_intrastate1 = $total_taxable_data_intrastate; //array of inter state supply
                }if ($get_total_non_gst == "" or $get_total_non_gst == NULL) {
                    $get_total_non_gst1 = array();
                    $get_total_non_gst1[$t] = 0; //array of inter state supply
                } else {
                    $get_total_non_gst1 = $get_total_non_gst; //array of inter state supply
                }if ($total_debit_data == "" or $total_debit_data == NULL) {
                    $total_debit_data1 = array();
                    $total_debit_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_debit_data1 = $total_debit_data; //array of inter state supply
                }if ($total_credit_data == "" or $total_credit_data == NULL) {
                    $total_credit_data1 = array();
                    $total_credit_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_credit_data1 = $total_credit_data; //array of inter state supply
                }if ($get_SUB_total_non_gst == "" or $get_SUB_total_non_gst == NULL) {
                    $get_SUB_total_non_gst1 = array();
                    $get_SUB_total_non_gst1[$t] = 0; //array of inter state supply
                } else {
                    $get_SUB_total_non_gst1 = $get_SUB_total_non_gst; //array of inter state supply
                }if ($get_SUB_total_exempt == "" or $get_SUB_total_exempt == NULL) {
                    $get_SUB_total_exempt1 = array();
                    $get_SUB_total_exempt1[$t] = 0; //array of inter state supply
                } else {
                    $get_SUB_total_exempt1 = $get_SUB_total_exempt; //array of inter state supply
                }if ($total_taxable_data_interstate == "" or $total_taxable_data_interstate == NULL) {
                    $total_tax_data_interstate1 = array();
                    $total_tax_data_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_tax_data_interstate1 = $total_taxable_data_interstate; //array of inter state supply
                }if ($total_tax_data_intrastate == "" or $total_tax_data_intrastate === NULL) {
                    $total_tax_data_intrastate1 = array();
                    $total_tax_data_intrastate1[$t] = 0; //array of inter state supply
                } else {
                    $total_tax_data_intrastate1 = $total_tax_data_intrastate; //array of inter state supply
                }if ($total_debit_tax_data == "" or $total_debit_tax_data == NULL) {
                    $total_debit_tax_data1 = array();
                    $total_debit_tax_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_debit_tax_data1 = $total_debit_tax_data; //array of inter state supply
                }if ($total_credit_tax_data == "" or $total_credit_tax_data == NULL) {
                    $total_credit_tax_data1 = array();
                    $total_credit_tax_data1[$t] = 0; //array of inter state supply
                } else {
                    $total_credit_tax_data1 = $total_credit_tax_data; //array of inter state supply
                }if ($total_b2b_interstate == "" or $total_b2b_interstate == NULL) {
                    $total_b2b_interstate1 = array();
                    $total_b2b_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_b2b_interstate1 = $total_b2b_interstate; //array of inter state supply
                }if ($intrastate_b2b == "" or $intrastate_b2b == NULL) {
                    $intrastate_b2b1 = array();
                    $intrastate_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $intrastate_b2b1 = $intrastate_b2b; //array of inter state supply
                }if ($total_b2c_interstate == "" or $total_b2c_interstate == NULL) {
                    $total_b2c_interstate1 = array();
                    $total_b2c_interstate1[$t] = 0; //array of inter state supply
                } else {
                    $total_b2c_interstate1 = $total_b2c_interstate; //array of inter state supply
                }if ($intrastate_b2c == "" or $intrastate_b2c == NULL) {
                    $intrastate_b2c1 = array();
                    $intrastate_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $intrastate_b2c1 = $intrastate_b2c; //array of inter state supply
                }if ($credit_b2b == "" or $credit_b2b == NULL) {
                    $credit_b2b1 = array();
                    $credit_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $credit_b2b1 = $credit_b2b; //array of inter state supply
                }if ($debit_b2b == "" or $debit_b2b == NULL) {
                    $debit_b2b1 = array();
                    $debit_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $debit_b2b1 = $debit_b2b; //array of inter state supply
                }if ($total_taxable_advance_no_invoice == "" or $total_taxable_advance_no_invoice == NULL) {
                    $total_taxable_advance_no_invoice1 = array();
                    $total_taxable_advance_no_invoice1[$t] = 0; //array of inter state supply
                } else {
                    $total_taxable_advance_no_invoice1 = $total_taxable_advance_no_invoice; //array of inter state supply
                }if ($total_tax_advance_no_invoice == "" or $total_tax_advance_no_invoice == NULL) {
                    $total_tax_advance_no_invoice1 = array();
                    $total_tax_advance_no_invoice1[$t] = 0; //array of inter state supply
                } else {
                    $total_tax_advance_no_invoice1 = $total_tax_advance_no_invoice; //array of inter state supply
                }if ($total_taxable_advance_invoice == "" or $total_taxable_advance_invoice == NULL) {
                    $total_taxable_advance_invoice1 = array();
                    $total_taxable_advance_invoice1[$t] = 0; //array of inter state supply
                } else {
                    $total_taxable_advance_invoice1 = $total_taxable_advance_invoice; //array of inter state supply
                }if ($total_tax_advance_invoice == "" or $total_tax_advance_invoice == NULL) {
                    $total_tax_advance_invoice1 = array();
                    $total_tax_advance_invoice1[$t] = 0; //array of inter state supply
                } else {
                    $total_tax_advance_invoice1 = $total_tax_advance_invoice; //array of inter state supply
                }if ($advance_invoice_not_issue_b2b == "" or $advance_invoice_not_issue_b2b == NULL) {
                    $advance_invoice_not_issue_b2b1 = array();
                    $advance_invoice_not_issue_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $advance_invoice_not_issue_b2b1 = $advance_invoice_not_issue_b2b; //array of inter state supply
                }if ($advance_invoice_issue_b2b == "" or $advance_invoice_issue_b2b == NULL) {
                    $advance_invoice_issue_b2b1 = array();
                    $advance_invoice_issue_b2b1[$t] = 0; //array of inter state supply
                } else {
                    $advance_invoice_issue_b2b1 = $advance_invoice_issue_b2b; //array of inter state supply
                }if ($total_taxable_data_gst_export == "" or $total_taxable_data_gst_export == NULL) {
                    $total_taxable_data_gst_export1 = array();
                    $total_taxable_data_gst_export1[$t] = 0; //array of inter state supply
                } else {
                    $total_taxable_data_gst_export1 = $total_taxable_data_gst_export; //array of inter state supply
                }if ($total_tax_data_gst_export == "" or $total_tax_data_gst_export == NULL) {
                    $total_tax_data_gst_export1 = array();
                    $total_tax_data_gst_export1[$t] = 0; //array of inter state supply
                } else {
                    $total_tax_data_gst_export1 = $total_tax_data_gst_export; //array of inter state supply
                }if ($total_non_gst_export == "" or $total_non_gst_export == NULL) {
                    $total_non_gst_export1 = array();
                    $total_non_gst_export1[$t] = 0; //array of inter state supply
                } else {
                    $total_non_gst_export1 = $total_non_gst_export; //array of inter state supply
                }
                if ($adv_no_invoice_b2c == "" or $adv_no_invoice_b2c == NULL) {
                    $adv_no_invoice_b2c1 = array();
                    $adv_no_invoice_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $adv_no_invoice_b2c1 = $adv_no_invoice_b2c; //array of inter state supply
                }
                if ($adv_invoice_b2c == "" or $adv_invoice_b2c == NULL) {
                    $adv_invoice_b2c1 = array();
                    $adv_invoice_b2c1[$t] = 0; //array of inter state supply
                } else {
                    $adv_invoice_b2c1 = $adv_invoice_b2c; //array of inter state supply
                }
                if ($nil_rated_value == "" or $nil_rated_value == NULL) {
                    $nil_rated_value1 = array();
                    $nil_rated_value1[$t] = 0; //array of inter state supply
                } else {
                    $nil_rated_value1 = $nil_rated_value; //array of inter state supply
                }
                $insert_id = $this->generate_insert_id();

                $quer = $this->db2->query("insert into monthly_summary_all (`customer_id`,`insert_id`,`month`,`inter_state_supply`,`intra_state_supply`,`no_gst_paid_supply`,`debit_value`,"
                        . "`credit_value`,`sub_total_non_gst`,`sub_total_exempt`,`tax_inter_state`,`tax_intra_state`,`tax_debit`,`tax_credit`,`interstate_b2b`,`intrastate_b2b`,`interstate_b2c`,"
                        . "`intrastate_b2c`,`credit_b2b`,`credit_b2c`,`debit_b2b`,`debit_b2c`,`total_taxable_advance_no_invoice`,`total_tax_advance_no_invoice`,`total_taxable_advance_invoice`"
                        . ",`total_tax_advance_invoice`,`advance_invoice_not_issue_b2b`,`advance_invoice_issue_b2b`,`total_taxable_data_gst_export`,`total_tax_data_gst_export`,"
                        . "`total_non_gst_export`,`advance_invoice_not_issue_b2c`,`advance_invoice_issue_b2c`,`sub_total_nil_rated`)"
                        . " values ('$customer_id','$insert_id','$month_data_arr[$t]','$total_taxable_data_interstate1[$t]','$total_taxable_data_intrastate1[$t]','$get_total_non_gst1[$t]',"
                        . "'$total_debit_data1[$t]','$total_credit_data1[$t]','$get_SUB_total_non_gst1[$t]','$get_SUB_total_exempt1[$t]','$total_tax_data_interstate1[$t]',"
                        . "'$total_tax_data_intrastate1[$t]','$total_debit_tax_data1[$t]','$total_credit_tax_data1[$t]','$total_b2b_interstate1[$t]','$intrastate_b2b1[$t]'"
                        . ",'$total_b2c_interstate1[$t]','$intrastate_b2c1[$t]','$credit_b2b1[$t]','$get_credit_b2c1[$t]','$debit_b2b1[$t]','$get_debit_b2c1[$t]','$total_taxable_advance_no_invoice1[$t]',"
                        . "'$total_tax_advance_no_invoice1[$t]','$total_taxable_advance_invoice1[$t]','$total_tax_advance_invoice1[$t]','$advance_invoice_not_issue_b2b1[$t]','$advance_invoice_issue_b2b1[$t]',"
                        . "'$total_taxable_data_gst_export1[$t]','$total_tax_data_gst_export1[$t]','$total_non_gst_export1[$t]','$adv_no_invoice_b2c1[$t]','$adv_invoice_b2c1[$t]','$nil_rated_value1[$t]') ");
                if ($this->db2->affected_rows() > 0) {
                    $vall++;
                }
            }
        }
        return $vall;
    }

    public function advance_invoice_not_issue_b2b_fun($highest_value, $i, $object) {
        $data_arr_adv_no_invoice = array();
        $highest_value_without_GT = $highest_value; // got last value here for if
        $char = 'G';
        while ($char !== $highest_value_without_GT) {
            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values);
//             exit;
//For getting the value for tax inter state 
        $data_arr_adv_no_in = array();

        for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
            $Dr_values = $values[$a_dr];
            $data_arr_adv_no_in[] = $values[$a_dr];
        }
        for ($aa = 0; $aa < $cnt; $aa++) {
//            $data1 = $values[$aa];
            $data_arr_adv_no_invoice[] = $values[$aa];
            $aa = ($aa * 1 + 4);
        }
        return $data_arr_adv_no_invoice;
    }

    public function advance_invoice_not_issue_fun($highest_value, $i, $object) { // Total value of Adavnce Received but invoice not issued in same period
        $tax_adv_no_invoice = array();
        $data_arr_adv_no_invoice = array();

        $highest_value_without_GT = $highest_value; // got last value here for if

        $char = 'G';
        while ($char !== $highest_value_without_GT) {
            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values);
//             exit;
//For getting the value for tax inter state 
        $data_arr_adv_no_in = array();

        for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
            $Dr_values = $values[$a_dr];
            $data_arr_adv_no_in[] = $values[$a_dr];
        }

        $aa1 = array();
//            echo sizeof($values);
        for ($a_dr = 1; $a_dr < $cnt; $a_dr++) {

            if ($a_dr % 5 != 0) {

                $aa1[] = $values[$a_dr];
            }
        }
        $a1 = (sizeof($aa1));
        $a2 = $a1 % 1;
        $a3 = $a1 - $a2;
        for ($k = 0; $k < ($a3); $k = $k + 4) {

            $tax_adv_no_invoice[] = $aa1[$k] + $aa1[$k + 1] + $aa1[$k + 2] + $aa1[$k + 3];
        }
//        $cnt = count($values);
        for ($aa = 0; $aa < $cnt; $aa++) {
//            $data1 = $values[$aa];
            $data_arr_adv_no_invoice[] = $values[$aa];
            $aa = ($aa * 1 + 4);
        }
//        return $tax_inter_state;
        return array($data_arr_adv_no_invoice, $tax_adv_no_invoice);
    }

//Function for 3-B offset file

    public function tboffset_file_function($path1, $insert_id, $customer_id, $values) {
        $object1 = PHPExcel_IOFactory::load($path1);
        $worksheet1 = $object1->getActiveSheet();
        $highestRow1 = $worksheet1->getHighestRow();
        $highestColumn1 = $worksheet1->getHighestColumn();
        $customer_file_years = $this->input->post('customer_file_years');

        $abcl = $object1->getActiveSheet()->getCell('B' . 3)->getValue();
//             echo $abcl;
        $a = (explode(" : ", $abcl));
        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        } else if ($customer_file_years == $a[1]) {

            if ($object1->getActiveSheet()->getCell('B' . 1)->getValue() === "Consolidated 3B Offset Summary") {
                $month = array();
                $liability_on_outward = array();
                for ($l = 10; $l <= 18; $l++) {
                    $month[] = $object1->getActiveSheet()->getCell('B' . $l)->getValue();
                    $val = $object1->getActiveSheet()->getCell('F' . $l)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $l)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $l)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $l)->getValue();
                    $liability_on_outward[] = $val + $val1 + $val2 + $val3;
//                    var_dump($liability_on_outward);
//                    print_r($liability_on_outward);
                }
                $rcm_liability = array();
                for ($m = 27; $m <= 35; $m++) {
                    $val = $object1->getActiveSheet()->getCell('F' . $m)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $m)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $m)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $m)->getValue();
                    $rcm_liability[] = $val + $val1 + $val2 + $val3;
//                     print_r($rcm_liability);
                }

                $itc_ineligible = array();
                for ($n = 44; $n <= 52; $n++) {
                    $val = $object1->getActiveSheet()->getCell('P' . $n)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('Q' . $n)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('R' . $n)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('S' . $n)->getValue();
                    $itc_ineligible[] = $val + $val1 + $val2 + $val3;
//                     print_r($itc_ineligible);
                }

                $net_rtc = array();
                for ($o = 44; $o <= 52; $o++) {
                    $val = $object1->getActiveSheet()->getCell('D' . $o)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('E' . $o)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('F' . $o)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('G' . $o)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('H' . $o)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('I' . $o)->getValue();
                    $val6 = $object1->getActiveSheet()->getCell('J' . $o)->getValue();
                    $val7 = $object1->getActiveSheet()->getCell('K' . $o)->getValue();
                    $net_rtc[] = $val + $val1 + $val2 + $val3 + $val4 + $val5 + $val6 + $val7;
//                    print_r($net_rtc);
                }


                $paid_in_credit = array();
                for ($p = 10; $p <= 18; $p++) {
                    $val = $object1->getActiveSheet()->getCell('J' . $p)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('K' . $p)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('L' . $p)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('M' . $p)->getValue();
                    $paid_in_credit[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_credit);
                }


                $paid_in_cash1 = array();
                for ($q = 10; $q <= 18; $q++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $q)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $q)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $q)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $q)->getValue();
                    $paid_in_cash1[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_cash1);
                }

                $paid_in_cash2 = array();
                for ($r = 27; $r <= 35; $r++) {
                    $val = $object1->getActiveSheet()->getCell('J' . $r)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('K' . $r)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('L' . $r)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('M' . $r)->getValue();
                    $paid_in_cash2[] = $val + $val1 + $val2 + $val3;
                }

//Sum of above two array
                $paid_in_cash = array_map(function () {
                    return array_sum(func_get_args());
                }, $paid_in_cash1, $paid_in_cash2);


                $interest_late_fees = array();
                for ($s = 27; $s <= 35; $s++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $s)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $s)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $s)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $s)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('R' . $s)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('S' . $s)->getValue();
                    $interest_late_fees[] = $val + $val1 + $val2 + $val3 + $val4 + $val5;
//                    print_r($interest_late_fees);
                }

                $due_date = array();
                for ($t = 10; $t <= 18; $t++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $t)->getValue();
                    $due_date[] = $val;
//                    print_r($due_date);
                }
                $filling_date = array();
                for ($u = 10; $u <= 18; $u++) {
                    $val = $object1->getActiveSheet()->getCell('S' . $u)->getValue();
                    $filling_date[] = $val;
//                    print_r($interest_late_fees);
                }
                $late_fees = array();
                for ($v = 27; $v <= 35; $v++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $v)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('S' . $v)->getValue();
                    $filling_date[] = $val + $val1;
//                    print_r($interest_late_fees);
                }
            } else {
                $liability_on_outward = array();
                for ($l = 7; $l <= 18; $l++) {
//                    $month[];
                    $val = $object1->getActiveSheet()->getCell('F' . $l)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $l)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $l)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $l)->getValue();
                    $liability_on_outward[] = $val + $val1 + $val2 + $val3;
//                    var_dump($liability_on_outward);
//                    print_r($liability_on_outward);
                }

                $rcm_liability = array();
                for ($m = 24; $m <= 35; $m++) {
                    $val = $object1->getActiveSheet()->getCell('F' . $m)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('G' . $m)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('H' . $m)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('I' . $m)->getValue();
                    $rcm_liability[] = $val + $val1 + $val2 + $val3;
//                     print_r($rcm_liability);
                }
                $itc_ineligible = array();
                for ($n = 41; $n <= 52; $n++) {
                    $val = $object1->getActiveSheet()->getCell('P' . $n)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('Q' . $n)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('R' . $n)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('S' . $n)->getValue();
                    $itc_ineligible[] = $val + $val1 + $val2 + $val3;
//                     print_r($itc_ineligible);
                }

                $net_rtc = array();
                for ($o = 41; $o <= 52; $o++) {
                    $val = $object1->getActiveSheet()->getCell('D' . $o)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('E' . $o)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('F' . $o)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('G' . $o)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('H' . $o)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('I' . $o)->getValue();
                    $val6 = $object1->getActiveSheet()->getCell('J' . $o)->getValue();
                    $val7 = $object1->getActiveSheet()->getCell('K' . $o)->getValue();
                    $net_rtc[] = $val + $val1 + $val2 + $val3 + $val4 + $val5 + $val6 + $val7;
//                    print_r($net_rtc);
                }

                $paid_in_credit = array();
                for ($p = 7; $p <= 18; $p++) {
                    $val = $object1->getActiveSheet()->getCell('J' . $p)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('K' . $p)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('L' . $p)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('M' . $p)->getValue();
                    $paid_in_credit[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_credit);
                }

                $paid_in_cash1 = array();
                for ($q = 7; $q <= 18; $q++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $q)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $q)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $q)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $q)->getValue();
                    $paid_in_cash1[] = $val + $val1 + $val2 + $val3;
//                     print_r($paid_in_cash1);
                }

                $paid_in_cash2 = array();
                for ($r = 24; $r <= 35; $r++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $r)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $r)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $r)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $r)->getValue();
                    $paid_in_cash2[] = $val + $val1 + $val2 + $val3;
                }
//                $c = array_map(function () {
//    return array_sum(func_get_args());
//            }, $paid_in_cash1, $paid_in_cash2);
//               print_r($c); 

                $interest_late_fees = array();
                for ($s = 24; $s <= 35; $s++) {
                    $val = $object1->getActiveSheet()->getCell('N' . $s)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('O' . $s)->getValue();
                    $val2 = $object1->getActiveSheet()->getCell('P' . $s)->getValue();
                    $val3 = $object1->getActiveSheet()->getCell('Q' . $s)->getValue();
                    $val4 = $object1->getActiveSheet()->getCell('R' . $s)->getValue();
                    $val5 = $object1->getActiveSheet()->getCell('S' . $s)->getValue();
                    $interest_late_fees[] = $val + $val1 + $val2 + $val3 + $val4 + $val5;
                }

                $due_date = array();
                for ($t = 7; $t <= 18; $t++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $t)->getValue();
                    $due_date[] = $val;
                }

                $filling_date = array();
                for ($u = 7; $u <= 18; $t++) {
                    $val = $object1->getActiveSheet()->getCell('S' . $u)->getValue();
                    $filling_date[] = $val;
                }

                $late_fees = array();
                for ($v = 24; $v <= 35; $v++) {
                    $val = $object1->getActiveSheet()->getCell('R' . $v)->getValue();
                    $val1 = $object1->getActiveSheet()->getCell('S' . $v)->getValue();
                    $filling_date[] = $val + $val1;
                }
            }
        } else {
            $response['id'] = 'file_ex2';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
            echo json_encode($response);
            exit;
        }
//             return $year;

        $count = count($month);

        $customer_id = $this->input->post('cust_id');
        $query = $this->db2->query("SELECT * FROM `3b_offset_summary_all` where customer_id='$customer_id'");
        if ($this->db2->affected_rows() > 0) {
            $offset_history = $this->insert_3boffset_summary_history($customer_id);
            if ($offset_history == true) {
                for ($m = 0; $m < $count; $m++) {
                    if ($month == "" or $month == NULL) {
                        $month = array();
                        $month1[$m] = 0;
                    } else {
                        $month1 = $month;
                    }
                    if ($liability_on_outward == "" or $liability_on_outward == NULL) {
                        $liability_on_outward = array();
                        $liability_on_outward1[$m] = 0;
                    } else {
                        $liability_on_outward1 = $liability_on_outward;
                    }
                    if ($rcm_liability == "" or $rcm_liability == NULL) {
                        $rcm_liability = array();
                        $rcm_liability1[$m] = 0;
                    } else {
                        $rcm_liability1 = $rcm_liability;
                    }
                    if ($itc_ineligible == "" or $itc_ineligible == NULL) {
                        $itc_ineligible = array();
                        $itc_ineligible1[$m] = 0;
                    } else {
                        $itc_ineligible1 = $itc_ineligible;
                    }
                    if ($net_rtc == "" or $net_rtc == NULL) {
                        $net_rtc = array();
                        $net_rtc1[$m] = 0;
                    } else {
                        $net_rtc1 = $net_rtc;
                    }
                    if ($paid_in_credit == "" or $paid_in_credit == NULL) {
                        $paid_in_credit = array();
                        $paid_in_credit1[$m] = 0;
                    } else {
                        $paid_in_credit1 = $paid_in_credit;
                    }
                    if ($paid_in_cash == "" or $paid_in_cash == NULL) {
                        $paid_in_cash = array();
                        $paid_in_cash1[$m] = 0;
                    } else {
                        $paid_in_cash1 = $paid_in_cash;
                    }
                    if ($interest_late_fees == "" or $interest_late_fees == NULL) {
                        $interest_late_fees = array();
                        $interest_late_fees1[$m] = 0;
                    } else {
                        $interest_late_fees1 = $interest_late_fees;
                    }

                    if ($due_date == "" or $due_date == NULL) {
                        $due_date = array();
                        $due_date1[$m] = 0;
                    } else {
                        $due_date1 = $due_date;
                    }
                    if ($filling_date == "" or $filling_date == NULL) {
                        $filling_date = array();
                        $filling_date1[$m] = 0;
                    } else {
                        $filling_date1 = $filling_date;
                    }
                    if ($late_fees == "" or $late_fees == NULL) {
                        $late_fees = array();
                        $late_fees1[$m] = 0;
                    } else {
                        $late_fees1 = $late_fees;
                    }

                    $insert_id = $this->generate_insert_id();
                    $quer3B_offset = $this->db2->query("insert into 3b_offset_summary_all (`insert_id`,`customer_id`,`month`,`outward_liability`,`rcb_liablity`,`ineligible_itc`,`net_itc`,`paid_in_credit`,`paid_in_cash`,`interest_late_fee`,`late_fees`,`due_date`,`filling_date`)"
                            . " values ('$insert_id','$customer_id','$month1[$m]','$liability_on_outward1[$m]','$rcm_liability1[$m]','$itc_ineligible1[$m]','$net_rtc1[$m]','$paid_in_credit1[$m]','$paid_in_cash1[$m]','$interest_late_fees1[$m]','$late_fees1[$m]','$due_date1[$m]','$filling_date1[$m]')");

                    if ($this->db2->affected_rows() > 0) {
                        $values++;
                    }
                }
            }
        } else {
            for ($m = 0; $m < $count; $m++) {
                if ($month == "" or $month == NULL) {
                    $month = array();
                    $month1[$m] = 0;
                } else {
                    $month1 = $month;
                }
                if ($liability_on_outward == "" or $liability_on_outward == NULL) {
                    $liability_on_outward = array();
                    $liability_on_outward1[$m] = 0;
                } else {
                    $liability_on_outward1 = $liability_on_outward;
                }
                if ($rcm_liability == "" or $rcm_liability == NULL) {
                    $rcm_liability = array();
                    $rcm_liability1[$m] = 0;
                } else {
                    $rcm_liability1 = $rcm_liability;
                }
                if ($itc_ineligible == "" or $itc_ineligible == NULL) {
                    $itc_ineligible = array();
                    $itc_ineligible1[$m] = 0;
                } else {
                    $itc_ineligible1 = $itc_ineligible;
                }
                if ($net_rtc == "" or $net_rtc == NULL) {
                    $net_rtc = array();
                    $net_rtc1[$m] = 0;
                } else {
                    $net_rtc1 = $net_rtc;
                }
                if ($paid_in_credit == "" or $paid_in_credit == NULL) {
                    $paid_in_credit = array();
                    $paid_in_credit1[$m] = 0;
                } else {
                    $paid_in_credit1 = $paid_in_credit;
                }
                if ($paid_in_cash == "" or $paid_in_cash == NULL) {
                    $paid_in_cash = array();
                    $paid_in_cash1[$m] = 0;
                } else {
                    $paid_in_cash1 = $paid_in_cash;
                }
                if ($interest_late_fees == "" or $interest_late_fees == NULL) {
                    $interest_late_fees = array();
                    $interest_late_fees1[$m] = 0;
                } else {
                    $interest_late_fees1 = $interest_late_fees;
                }

                if ($due_date == "" or $due_date == NULL) {
                    $due_date = array();
                    $due_date1[$m] = 0;
                } else {
                    $due_date1 = $due_date;
                }
                if ($filling_date == "" or $filling_date == NULL) {
                    $filling_date = array();
                    $filling_date1[$m] = 0;
                } else {
                    $filling_date1 = $filling_date;
                }
                if ($late_fees == "" or $late_fees == NULL) {
                    $late_fees = array();
                    $late_fees1[$m] = 0;
                } else {
                    $late_fees1 = $late_fees;
                }

                $insert_id = $this->generate_insert_id();
                $quer3B_offset = $this->db2->query("insert into 3b_offset_summary_all (`insert_id`,`customer_id`,`month`,`outward_liability`,`rcb_liablity`,`ineligible_itc`,`net_itc`,`paid_in_credit`,`paid_in_cash`,`interest_late_fee`,`late_fees`,`due_date`,`filling_date`)"
                        . " values ('$insert_id','$customer_id','$month1[$m]','$liability_on_outward1[$m]','$rcm_liability1[$m]','$itc_ineligible1[$m]','$net_rtc1[$m]','$paid_in_credit1[$m]','$paid_in_cash1[$m]','$interest_late_fees1[$m]','$late_fees1[$m]','$due_date1[$m]','$filling_date1[$m]')");

                if ($this->db2->affected_rows() > 0) {
                    $values++;
                }
            }
        }
        return $values;
    }

//Function for reconcillation 

    public function reconcillation_summary_function($path3, $value_insert_nrc, $value_insert, $value_insert_p_match) {
//          $this->load->library('excel');
        $object = PHPExcel_IOFactory::load($path3);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $customer_id = $this->input->post("cust_id");
        $customer_file_years = $this->input->post('customer_file_years');
        $insert_id = $this->generate_insert_id();
        $abc2 = $object->getActiveSheet()->getCell('A' . 1)->getValue();
        $xy = explode(":", $abc2);
        $a1 = rtrim($xy[1], ')');

        $period_not_in_2a = array();
        $invoice_no_not_in_2a = array();
        $place_of_supply_not_in_2a = array();
        $invoice_date_not_in_2a = array();
        $invoice_value_not_in_2a = array();
        $taxable_value_not_in_2a = array();
        $company_name_not_in_2a = array();
        $tax_not_in_2a = array();
        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        } else if ($customer_file_years == $a1) {
            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Not in 2A") { //get records of not in 2a
                    $period_not_in_2a[] = $object->getActiveSheet()->getCell("C" . $i)->getValue();
                    $invoice_no_not_in_2a[] = $object->getActiveSheet()->getCell("D" . $i)->getValue();
                    $place_of_supply_not_in_2a[] = $object->getActiveSheet()->getCell("E" . $i)->getValue();
                    $invoice_date_old = $object->getActiveSheet()->getCell("F" . $i)->getValue();
                    $old_date_timestamp = strtotime($invoice_date_old);
                    $invoice_date_not_in_2a[] = date('Y-m-d', $old_date_timestamp);
                    $invoice_value_not_in_2a[] = $object->getActiveSheet()->getCell("G" . $i)->getValue();
                    $taxable_value_not_in_2a[] = $object->getActiveSheet()->getCell("H" . $i)->getValue();
                    $tax_not_in_2a[] = $object->getActiveSheet()->getCell("I" . $i)->getValue();
                    $x = 1;
//                    $insert_id = $this->generate_insert_id();

                    for ($j = $i; $j > 1; $j--) {
                        if ($object->getActiveSheet()->getCell("A" . $j)->getValue() == "As per Records") {
                            $prev_row = $j - 1;
                            $company_name_old = $object->getActiveSheet()->getCell("F" . $prev_row)->getValue();
                            $company_name_not_in_2a = substr($company_name_old, 0, -20);
                            $x++;
                        } else {
                            
                        }
                        if ($x > 1) {
                            break;
                        }
                    }
                } else {
                    
                }
            }

            $count = count($period_not_in_2a);

            $query = $this->db2->query("SELECT * FROM `gstr_2a_reconciliation_all` where customer_id='$customer_id'");
            if ($this->db2->affected_rows() > 0) {
                $reconcill_history = $this->insert_reconcillation_summary_history($customer_id);
                if ($reconcill_history == true) {
                    for ($k = 0; $k < $count; $k++) {

                        if ($period_not_in_2a[$k] == "") {
                            $period_not_in_2a[$k] = "0";
                        }
                        if ($invoice_no_not_in_2a[$k] == "") {
                            $invoice_no_not_in_2a[$k] = "0";
                        }
                        if ($place_of_supply_not_in_2a[$k] == "") {
                            $place_of_supply_not_in_2a[$k] = "0";
                        }
                        if ($invoice_date_not_in_2a[$k] == "") {
                            $invoice_date_not_in_2a[$k] = "0";
                        }
                        if ($invoice_value_not_in_2a[$k] == "") {
                            $invoice_value_not_in_2a[$k] = "0";
                        }
                        if ($taxable_value_not_in_2a[$k] == "") {
                            $taxable_value_not_in_2a[$k] = "0";
                        }
                        if ($tax_not_in_2a[$k] == "") {
                            $tax_not_in_2a[$k] = "0";
                        }

                        $query = ("insert into gstr_2a_reconciliation_all (`customer_id`,`insert_id`,`status`,`period`,`invoice_no`,`place_of_supply`,`invoice_date`,`invoice_value`,`taxable_value`,`tax`)values (?,?,?,?,?,?,?,?,?,?)");
                        $this->db2->query($query, array($customer_id, $insert_id, 'not_in_2a', $period_not_in_2a[$k], $invoice_no_not_in_2a[$k], $place_of_supply_not_in_2a[$k], $invoice_date_not_in_2a[$k], $invoice_value_not_in_2a[$k], $taxable_value_not_in_2a[$k], $tax_not_in_2a[$k]));
                        if ($this->db2->affected_rows() > 0) {
//                                    $value_insert++;
                        }
                    }
                }
            } else {
                for ($k = 0; $k < $count; $k++) {

                    if ($period_not_in_2a[$k] == "") {
                        $period_not_in_2a[$k] = "0";
                    }
                    if ($invoice_no_not_in_2a[$k] == "") {
                        $invoice_no_not_in_2a[$k] = "0";
                    }
                    if ($place_of_supply_not_in_2a[$k] == "") {
                        $place_of_supply_not_in_2a[$k] = "0";
                    }
                    if ($invoice_date_not_in_2a[$k] == "") {
                        $invoice_date_not_in_2a[$k] = "0";
                    }
                    if ($invoice_value_not_in_2a[$k] == "") {
                        $invoice_value_not_in_2a[$k] = "0";
                    }
                    if ($taxable_value_not_in_2a[$k] == "") {
                        $taxable_value_not_in_2a[$k] = "0";
                    }
                    if ($tax_not_in_2a[$k] == "") {
                        $tax_not_in_2a[$k] = "0";
                    }

                    $query = ("insert into gstr_2a_reconciliation_all (`customer_id`,`insert_id`,`status`,`period`,`invoice_no`,`place_of_supply`,`invoice_date`,`invoice_value`,`taxable_value`,`tax`)values (?,?,?,?,?,?,?,?,?,?)");
                    $this->db2->query($query, array($customer_id, $insert_id, 'not_in_2a', $period_not_in_2a[$k], $invoice_no_not_in_2a[$k], $place_of_supply_not_in_2a[$k], $invoice_date_not_in_2a[$k], $invoice_value_not_in_2a[$k], $taxable_value_not_in_2a[$k], $tax_not_in_2a[$k]));
                    if ($this->db2->affected_rows() > 0) {
//                                $value_insert++;
                    }
                }
            }
//                    return $value_insert;

            $period_not_in_rec = array();
            $invoice_no_not_in_rec = array();
            $pos_not_in_rec = array();
            $invoice_date_not_in_rec = array();
            $invoce_value_not_in_rec = array();
            $taxable_value_not_in_rec = array();
            $tax_not_in_rec = array();
            $company_name_not_in_rec = array();
            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Not in Rec") { //get records of not in records
                    $x = 1;
                    $period_not_in_rec[] = $object->getActiveSheet()->getCell("Q" . $i)->getValue();
                    $invoice_no_not_in_rec[] = $object->getActiveSheet()->getCell("R" . $i)->getValue();
                    $pos_not_in_rec[] = $object->getActiveSheet()->getCell("S" . $i)->getValue();
                    $invoice_date_old = $object->getActiveSheet()->getCell("T" . $i)->getValue();
                    $old_date_timestamp = strtotime($invoice_date_old);
                    $invoice_date_not_in_rec[] = date('Y-m-d', $old_date_timestamp);
                    $invoce_value_not_in_rec[] = $object->getActiveSheet()->getCell("U" . $i)->getValue();
                    $taxable_value_not_in_rec[] = $object->getActiveSheet()->getCell("V" . $i)->getValue();
                    $tax_not_in_rec[] = $object->getActiveSheet()->getCell("W" . $i)->getValue();
                    $insert_id = $this->generate_insert_id();
                    for ($j1 = $i; $j1 > 1; $j1--) {
                        if ($object->getActiveSheet()->getCell("A" . $j1)->getValue() == "As per Records") {
                            $prev_row = $j1 - 1;
                            $company_name_old = $object->getActiveSheet()->getCell("F" . $prev_row)->getValue();
                            $company_name_not_in_rec[] = substr($company_name_old, 0, -20);
                            $x++;
                        } else {
                            
                        }
                        if ($x > 1) {
                            break;
                        }
                    }
                } else {
                    
                }
            }

            $count = count($period_not_in_rec);
            $query = $this->db2->query("SELECT * FROM `gstr_2a_reconciliation_all` where customer_id='$customer_id'");
            if ($this->db2->affected_rows() > 0) {

                $reconcill_history = $this->insert_reconcillation_summary_history($customer_id);
                if ($reconcill_history == true) {
                    for ($k = 0; $k < $count; $k++) {

                        if ($period_not_in_rec[$k] == "") {
                            $period_not_in_rec[$k] = "0";
                        }
                        if ($invoice_no_not_in_rec[$k] == "") {
                            $invoice_no_not_in_rec[$k] = "0";
                        }
                        if ($pos_not_in_rec[$k] == "") {
                            $pos_not_in_rec[$k] = "0";
                        }
                        if ($invoice_date_not_in_rec[$k] == "") {
                            $invoice_date_not_in_rec[$k] = "0";
                        }
                        if ($invoce_value_not_in_rec[$k] == "") {
                            $invoce_value_not_in_rec[$k] = "0";
                        }
                        if ($taxable_value_not_in_rec[$k] == "") {
                            $taxable_value_not_in_rec[$k] = "0";
                        }
                        if ($tax_not_in_rec[$k] == "") {
                            $tax_not_in_rec[$k] = "0";
                        }

                        $query = ("insert into gstr_2a_reconciliation_all (`customer_id`,`insert_id`,`status`,`period`,`invoice_no`,`place_of_supply`,`invoice_date`,`invoice_value`,`taxable_value`,`tax`)values (?,?,?,?,?,?,?,?,?,?)");
                        $this->db2->query($query, array($customer_id, $insert_id, 'not_in_rec', $period_not_in_rec[$k], $invoice_no_not_in_rec[$k], $pos_not_in_rec[$k], $invoice_date_not_in_rec[$k], $invoce_value_not_in_rec[$k], $taxable_value_not_in_rec[$k], $tax_not_in_rec[$k]));
                        if ($this->db2->affected_rows() > 0) {
//                                    $value_insert_nrc++;
                        }
                    }
                } else {
                    for ($k = 0; $k < $count; $k++) {

                        if ($period_not_in_rec[$k] == "") {
                            $period_not_in_rec[$k] = "0";
                        }
                        if ($invoice_no_not_in_rec[$k] == "") {
                            $invoice_no_not_in_rec[$k] = "0";
                        }
                        if ($pos_not_in_rec[$k] == "") {
                            $pos_not_in_rec[$k] = "0";
                        }
                        if ($invoice_date_not_in_rec[$k] == "") {
                            $invoice_date_not_in_rec[$k] = "0";
                        }
                        if ($invoce_value_not_in_rec[$k] == "") {
                            $invoce_value_not_in_rec[$k] = "0";
                        }
                        if ($taxable_value_not_in_rec[$k] == "") {
                            $taxable_value_not_in_rec[$k] = "0";
                        }
                        if ($tax_not_in_rec[$k] == "") {
                            $tax_not_in_rec[$k] = "0";
                        }

                        $query = ("insert into gstr_2a_reconciliation_all (`customer_id`,`insert_id`,`status`,`period`,`invoice_no`,`place_of_supply`,`invoice_date`,`invoice_value`,`taxable_value`,`tax`)values (?,?,?,?,?,?,?,?,?,?)");
                        $this->db2->query($query, array($customer_id, $insert_id, 'not_in_rec', $period_not_in_rec[$k], $invoice_no_not_in_rec[$k], $pos_not_in_rec[$k], $invoice_date_not_in_rec[$k], $invoce_value_not_in_rec[$k], $taxable_value_not_in_rec[$k], $tax_not_in_rec[$k]));
                        if ($this->db2->affected_rows() > 0) {
//                                $value_insert_nrc++;
                        }
                    }
                }
//                    return $value_insert_nrc;
            }


            $period_apr_partly_mat = array();
            $invoice_no_apr_partly_mat = array();
            $pos_apr_partly_mat = array();
            $period_ap2a_partly_mat = array();
            $invoice_no_ap2a_partly_mat = array();
            $pos_ap2a_partly_mat = array();
            $taxable_value_diff_partly_mat = array();
            $tax_diff_partly_mat = array();
            $company_name_partly_mat = array();

            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Partly Mat") { //get records of not in records
                    $x1 = 1;
//as per records data
                    $period_apr_partly_mat[] = $object->getActiveSheet()->getCell("C" . $i)->getValue();
                    $invoice_no_apr_partly_mat[] = $object->getActiveSheet()->getCell("D" . $i)->getValue();
                    $pos_apr_partly_mat[] = $object->getActiveSheet()->getCell("E" . $i)->getValue();
//as per GSTR-2A
                    $period_ap2a_partly_mat[] = $object->getActiveSheet()->getCell("Q" . $i)->getValue();
                    $invoice_no_ap2a_partly_mat[] = $object->getActiveSheet()->getCell("R" . $i)->getValue();
                    $pos_ap2a_partly_mat[] = $object->getActiveSheet()->getCell("S" . $i)->getValue();

//difference data
                    $taxable_value_diff_partly_mat[] = $object->getActiveSheet()->getCell("AJ" . $i)->getValue();
                    $tax_diff_partly_mat[] = $object->getActiveSheet()->getCell("AK" . $i)->getValue();

                    for ($j2 = $i; $j2 > 1; $j2--) {
                        if ($object->getActiveSheet()->getCell("A" . $j2)->getValue() == "As per Records") {
                            $prev_row = $j2 - 1;
                            $company_name_old = $object->getActiveSheet()->getCell("F" . $prev_row)->getValue();
                            $company_name_partly_mat[] = substr($company_name_old, 0, -20);
                            $x1++;
                        } else {
                            
                        }
                        if ($x1 > 1) {
                            break;
                        }
                    }
                }
            }


            $count = count($period_apr_partly_mat);
            $query = $this->db2->query("SELECT * FROM `gstr_2a_reconciliation_partially_match_summary` where customer_id='$customer_id'");
            if ($this->db2->affected_rows() > 0) {
                $state_wise_history = $this->insert_reconcillation_partial_summary_history($customer_id);
                if ($state_wise_history == true) {
                    for ($k = 0; $k < $count; $k++) {

                        if ($period_apr_partly_mat[$k] == "") {
                            $period_apr_partly_mat[$k] = "0";
                        }
                        if ($invoice_no_apr_partly_mat[$k] == "") {
                            $invoice_no_apr_partly_mat[$k] = "0";
                        }
                        if ($pos_apr_partly_mat[$k] == "") {
                            $pos_apr_partly_mat[$k] = "0";
                        }
                        if ($period_ap2a_partly_mat[$k] == "") {
                            $period_ap2a_partly_mat[$k] = "0";
                        }
                        if ($invoice_no_ap2a_partly_mat[$k] == "") {
                            $invoice_no_ap2a_partly_mat[$k] = "0";
                        }
                        if ($pos_ap2a_partly_mat[$k] == "") {
                            $pos_ap2a_partly_mat[$k] = "0";
                        }
                        if ($taxable_value_diff_partly_mat[$k] == "") {
                            $taxable_value_diff_partly_mat[$k] = "0";
                        }
                        if ($tax_diff_partly_mat[$k] == "") {
                            $tax_diff_partly_mat[$k] = "0";
                        }
                        if ($company_name_partly_mat[$k] == "") {
                            $company_name_partly_mat[$k] = "0";
                        }

                        $query = ("insert into gstr_2a_reconciliation_partially_match_summary (`customer_id`,`insert_id`,`company_name`,`status`,`period_apr`,`invoice_no_apr`,`place_of_supply_apr`,`period_2a`,`invoice_no_2a`,`place_of_supply_2a`,`taxable_value`,`tax`)values (?,?,?,?,?,?,?,?,?,?,?,?)");
                        $this->db2->query($query, array($customer_id, $insert_id, $company_name_partly_mat[$k], 'Partly_Mat', $period_apr_partly_mat[$k], $invoice_no_apr_partly_mat[$k], $pos_apr_partly_mat[$k], $period_ap2a_partly_mat[$k], $invoice_no_ap2a_partly_mat[$k], $pos_ap2a_partly_mat[$k], $taxable_value_diff_partly_mat[$k], $tax_diff_partly_mat[$k]));
                        if ($this->db2->affected_rows() > 0) {
                            $value_insert_p_match++;
                        }
                    }
                }
            } else {
                for ($k = 0; $k < $count; $k++) {

                    if ($period_apr_partly_mat[$k] == "") {
                        $period_apr_partly_mat[$k] = "0";
                    }
                    if ($invoice_no_apr_partly_mat[$k] == "") {
                        $invoice_no_apr_partly_mat[$k] = "0";
                    }
                    if ($pos_apr_partly_mat[$k] == "") {
                        $pos_apr_partly_mat[$k] = "0";
                    }
                    if ($period_ap2a_partly_mat[$k] == "") {
                        $period_ap2a_partly_mat[$k] = "0";
                    }
                    if ($invoice_no_ap2a_partly_mat[$k] == "") {
                        $invoice_no_ap2a_partly_mat[$k] = "0";
                    }
                    if ($pos_ap2a_partly_mat[$k] == "") {
                        $pos_ap2a_partly_mat[$k] = "0";
                    }
                    if ($taxable_value_diff_partly_mat[$k] == "") {
                        $taxable_value_diff_partly_mat[$k] = "0";
                    }
                    if ($tax_diff_partly_mat[$k] == "") {
                        $tax_diff_partly_mat[$k] = "0";
                    }
                    if ($company_name_partly_mat[$k] == "") {
                        $company_name_partly_mat[$k] = "0";
                    }

                    $query = ("insert into gstr_2a_reconciliation_partially_match_summary (`customer_id`,`insert_id`,`company_name`,`status`,`period_apr`,`invoice_no_apr`,`place_of_supply_apr`,`period_2a`,`invoice_no_2a`,`place_of_supply_2a`,`taxable_value`,`tax`)values (?,?,?,?,?,?,?,?,?,?,?,?)");
                    $this->db2->query($query, array($customer_id, $insert_id, $company_name_partly_mat[$k], 'Partly_Mat', $period_apr_partly_mat[$k], $invoice_no_apr_partly_mat[$k], $pos_apr_partly_mat[$k], $period_ap2a_partly_mat[$k], $invoice_no_ap2a_partly_mat[$k], $pos_ap2a_partly_mat[$k], $taxable_value_diff_partly_mat[$k], $tax_diff_partly_mat[$k]));
                    if ($this->db2->affected_rows() > 0) {
                        $value_insert_p_match++;
                    }
                }
            }
//                    return $value_insert_p_match;
            $arr1 = array($value_insert, $value_insert_nrc, $value_insert_p_match);
            return $arr1;
        } else {
            $response['id'] = 'file_ex_reconcill';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
            echo json_encode($response);
            exit;
        }
//        $arr1 = array($value_insert, $value_insert_nrc, $value_insert_p_match);
//        return $arr1;
    }

//Function for state wise summary

    public function state_wise_summary_function($path4, $sales_year_values) {
//function to get data from excel files

        $object = PHPExcel_IOFactory::load($path4);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $customer_id = $this->input->post("cust_id");
        $insert_id = $this->generate_insert_id();
        $customer_file_years = $this->input->post('customer_file_years');
        $j = 0;

        $abcl = $object->getActiveSheet()->getCell('A' . 3)->getValue();
//             echo $abcl;
        $aa = (explode(" ", $abcl));
//            print_r($aa);

        $b = substr($customer_file_years, 7);
        $a = substr($customer_file_years, 0, -4);

        $x = $a . $b;
//              echo $x;
        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        } else if ($aa[2] == $x) {
            $query = $this->db2->query("SELECT * FROM `state_wise_summary_all` where customer_id='$customer_id'");
            if ($this->db2->affected_rows() > 0) {
                $state_wise_history = $this->insert_state_wise_history($customer_id);
                if ($state_wise_history == true) {

                    for ($i = 8; $i <= $highestRow; $i++) { // loop to get last row number to get state
                        if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total") {
                            $j++;
                        }
                        if ($j > 0) {
                            break;
                        }
                    }
                    $total_row_num = $i;
                    $all_state = array();
                    $str = "(4) Cr Note Details";

                    for ($k = 8; $k < $total_row_num; $k++) { //loop get state data
                        $all_state[] = $object->getActiveSheet()->getCell('D' . $k)->getValue();
                    }
                    $states1 = array_unique($all_state); //unique array of state
                    $states = array_values($states1); //change array indexes
                    $count = count($states);
                    $a1 = 0;
                    $arr_taxable_value = array();
                    for ($m1 = 0; $m1 < $count; $m1++) {
                        if ($m1 < ($count)) {
                            $state_new = $states[$m1];
                        } else {
                            $state_new = $states[0];
                        }

                        $taxable_value = 0;

//                echo $highestRow;
                        for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise
                            $a2 = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                            if ($a2 == "(4) Cr Note Details") {
                                $a1 = 1;
                            } else if ($a2 == "(5) Dr Note Details") {
                                $a1 = 2;
                            }
                            if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == $state_new) {
                                if ($a1 == 0 or $a1 == 2) {
                                    $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                    $taxable_value += $tax_val;
                                } else if ($a1 == 1) {
                                    $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                    $taxable_value -= $tax_val;
                                }
                            }
                        }

                        $arr_taxable_value[] = $taxable_value;
                    }
//insert data of other states

                    for ($m = 0; $m < $count; $m++) {

                        $quer = $this->db2->query("insert into state_wise_summary_all (`customer_id`,`insert_id`,`state_name`,`taxable_value`)values ('$customer_id','$insert_id','$states[$m]','$arr_taxable_value[$m]')");
                    }
//            get array for maharashtra.
                    $taxable_value_mh = 0;
//            $arr_taxable_value_mh = array();
                    for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise
                        $a2 = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                        if ($a2 == "(4) Cr Note Details") {
                            $a1 = 1;
                        } else if ($a2 == "(5) Dr Note Details") {
                            $a1 = 2;
                        }
                        if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == "MAHARASHTRA") {
                            if ($a1 == 0 or $a1 == 2) {
                                $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                $taxable_value_mh += $tax_val;
                            } else if ($a1 == 1) {
                                $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                $taxable_value_mh -= $tax_val;
                            }
                        }
                    }
                    $taxable_value_mh = $taxable_value_mh;
                }
            } else {
                for ($i = 8; $i <= $highestRow; $i++) { // loop to get last row number to get state
                    if ($object->getActiveSheet()->getCell('B' . $i)->getValue() == "Total") {
                        $j++;
                    }
                    if ($j > 0) {
                        break;
                    }
                }
                $total_row_num = $i;
                $all_state = array();
                $str = "(4) Cr Note Details";

                for ($k = 8; $k < $total_row_num; $k++) { //loop get state data
                    $all_state[] = $object->getActiveSheet()->getCell('D' . $k)->getValue();
                }
                $states1 = array_unique($all_state); //unique array of state
                $states = array_values($states1); //change array indexes
                $count = count($states);
                $a1 = 0;
                $arr_taxable_value = array();
                for ($m1 = 0; $m1 < $count; $m1++) {
                    if ($m1 < ($count)) {
                        $state_new = $states[$m1];
                    } else {
                        $state_new = $states[0];
                    }

                    $taxable_value = 0;

//                echo $highestRow;
                    for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise
                        $a2 = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                        if ($a2 == "(4) Cr Note Details") {
                            $a1 = 1;
                        } else if ($a2 == "(5) Dr Note Details") {
                            $a1 = 2;
                        }
                        if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == $state_new) {
                            if ($a1 == 0 or $a1 == 2) {
                                $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                $taxable_value += $tax_val;
                            } else if ($a1 == 1) {
                                $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                                $taxable_value -= $tax_val;
                            }
                        }
                    }

                    $arr_taxable_value[] = $taxable_value;
                }
//insert data of other states

                for ($m = 0; $m < $count; $m++) {

                    $quer = $this->db2->query("insert into state_wise_summary_all (`customer_id`,`insert_id`,`state_name`,`taxable_value`)values ('$customer_id','$insert_id','$states[$m]','$arr_taxable_value[$m]')");
                    $sales_year_values++;
                }
//            get array for maharashtra.
                $taxable_value_mh = 0;
//            $arr_taxable_value_mh = array();
                for ($l = 8; $l <= $highestRow; $l++) { //loop to get data statewise
                    $a2 = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                    if ($a2 == "(4) Cr Note Details") {
                        $a1 = 1;
                    } else if ($a2 == "(5) Dr Note Details") {
                        $a1 = 2;
                    }
                    if ($object->getActiveSheet()->getCell('D' . $l)->getValue() == "MAHARASHTRA") {
                        if ($a1 == 0 or $a1 == 2) {
                            $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                            $taxable_value_mh += $tax_val;
                        } else if ($a1 == 1) {
                            $tax_val = $object->getActiveSheet()->getCell('E' . $l)->getValue();
                            $taxable_value_mh -= $tax_val;
                        }
                    }
                }
                $taxable_value_mh = $taxable_value_mh;
            }
//            return $taxable_value_mh;
        } else {
            $response['id'] = 'file_ex_state_wise';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
            echo json_encode($response);
            exit;
        }

//insert data of maharashtra

        $quer = $this->db2->query("insert into state_wise_summary_all (`customer_id`,`insert_id`,`state_name`,`taxable_value`)values ('$customer_id','$insert_id','MAHARASHTRA','$taxable_value_mh')");
        $sales_year_values++;
        return $sales_year_values;
    }

//function for without invoice summary

    public function without_invoice_summary_function($path5, $without_invoice) {

        $object = PHPExcel_IOFactory::load($path5);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $customer_id = $this->input->post("cust_id");
        $insert_id = $this->generate_insert_id();
        $customer_file_years = $this->input->post('customer_file_years');
        $original_month = array();
        $showing_month = array();
        $category = array();
        $gstin_arr = array();
        $invoice_date = array();
        $invoice_no = array();
        $name = array();
        $invoice_value = array();
        $taxable_value = array();
        $igst = array();
        $cgst = array();
        $sgst = array();
        $cess = array();
        $abc2 = $object->getActiveSheet()->getCell('A' . 3)->getValue();
        $x = filter_var($abc2, FILTER_SANITIZE_NUMBER_INT);
        $a1 = chunk_split($x, 4, "-");
        $a2 = rtrim($a1, '-');
//        exit;
        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        } else if ($customer_file_years == $a2) {
            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Original Month") { //get records of origial month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $og_mon = $object->getActiveSheet()->getCell("B" . $j)->getValue();
                        $original_month[] = $og_mon;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("C" . $i)->getValue() == "Showing in month") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $show_mon = $object->getActiveSheet()->getCell("C" . $j)->getValue();
                        $showing_month[] = $show_mon;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("D" . $i)->getValue() == "Category") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cat = $object->getActiveSheet()->getCell("D" . $j)->getValue();
                        $category[] = $cat;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("E" . $i)->getValue() == "GSTIN") { //get records of GSTIN
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $gstin = $object->getActiveSheet()->getCell("E" . $j)->getValue();
                        $gstin_arr[] = $gstin;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("F" . $i)->getValue() == "Invoice Date") { //get records of Invoice Date
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceDate = $object->getActiveSheet()->getCell("F" . $j)->getValue();
                        $invoice_date[] = $invoiceDate;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("G" . $i)->getValue() == "Invoice No") { //get records of Invoice No
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceno = $object->getActiveSheet()->getCell("G" . $j)->getValue();
                        $invoice_no[] = $invoiceno;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("H" . $i)->getValue() == "Name") { //get records of Names
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $names = $object->getActiveSheet()->getCell("H" . $j)->getValue();
                        $name[] = $names;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("I" . $i)->getValue() == "Invoice Value ") { //get records of Invoice Value 
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoice_val = $object->getActiveSheet()->getCell("I" . $j)->getValue();
                        $invoice_value[] = $invoice_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("J" . $i)->getValue() == "Taxable Value") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $tax_val = $object->getActiveSheet()->getCell("J" . $j)->getValue();
                        $taxable_value[] = $tax_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("K" . $i)->getValue() == "IGST") { //get records of IGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $igst_val = $object->getActiveSheet()->getCell("K" . $j)->getValue();
                        $igst[] = $igst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("L" . $i)->getValue() == "CGST") { //get records of CGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cgst_val = $object->getActiveSheet()->getCell("L" . $j)->getValue();
                        $cgst[] = $cgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("M" . $i)->getValue() == "SGST") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $sgst_val = $object->getActiveSheet()->getCell("M" . $j)->getValue();
                        $sgst[] = $sgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("N" . $i)->getValue() == "CESS") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cess_val = $object->getActiveSheet()->getCell("N" . $j)->getValue();
                        $cess[] = $cess_val;
                    }
                } else {
                    
                }
            }
        } else {
            $response['id'] = 'file_ex_withot_invoice';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
            echo json_encode($response);
            exit;
        }

        $count = count($original_month);
        $query = $this->db2->query("SELECT * FROM `invoice_not_included_gstr1` where customer_id='$customer_id'");
        if ($this->db2->affected_rows() > 0) {
            $monthly_history = $this->insert_without_invoice_history($customer_id);
            if ($monthly_history == true) {
                for ($k = 0; $k < $count; $k++) {

                    if ($original_month[$k] == "") {
                        $original_month[$k] = "0";
                    }
                    if ($showing_month[$k] == "") {
                        $showing_month[$k] = "0";
                    }
                    if ($category[$k] == "") {
                        $category[$k] = "0";
                    }
                    if ($gstin_arr[$k] == "") {
                        $gstin_arr[$k] = "0";
                    }
                    if ($invoice_date[$k] == "") {
                        $invoice_date[$k] = "0";
                    }
                    if ($invoice_no[$k] == "") {
                        $invoice_no[$k] = "0";
                    }
                    if ($name[$k] == "") {
                        $name[$k] = "Not Given";
                    }
                    if ($invoice_value[$k] == "") {
                        $invoice_value[$k] = "0";
                    }
                    if ($taxable_value[$k] == "") {
                        $taxable_value[$k] = "0";
                    }
                    if ($igst[$k] == "") {
                        $igst[$k] = "0";
                    }
                    if ($cgst[$k] == "") {
                        $cgst[$k] = "0";
                    }
                    if ($sgst[$k] == "") {
                        $sgst[$k] = "0";
                    }
                    if ($cess[$k] == "") {
                        $cess[$k] = "0";
                    }

                    $query = ("insert into invoice_not_included_gstr1 (`customer_id`,`insert_id`,`original_month`,`showing_month`,"
                            . "`category`,`gstin_no`,`invoice_date`,`invoice_no`,`name`,`invoice_value`,`taxable_value`,`igst`,`cgst`,`sgst`,`cess`)"
                            . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $this->db2->query($query, array($customer_id, $insert_id, $original_month[$k], $showing_month[$k], $category[$k], $gstin_arr[$k],
                        $invoice_date[$k], $invoice_no[$k], $name[$k], $invoice_value[$k], $taxable_value[$k], $igst[$k], $cgst[$k], $sgst[$k], $cess[$k]));
                    if ($this->db2->affected_rows() > 0) {
//                    echo'yes';
                        $without_invoice++;
                    }
                }
            }
        } else {
            for ($k = 0; $k < $count; $k++) {

                if ($original_month[$k] == "") {
                    $original_month[$k] = "0";
                }
                if ($showing_month[$k] == "") {
                    $showing_month[$k] = "0";
                }
                if ($category[$k] == "") {
                    $category[$k] = "0";
                }
                if ($gstin_arr[$k] == "") {
                    $gstin_arr[$k] = "0";
                }
                if ($invoice_date[$k] == "") {
                    $invoice_date[$k] = "0";
                }
                if ($invoice_no[$k] == "") {
                    $invoice_no[$k] = "0";
                }
                if ($name[$k] == "") {
                    $name[$k] = "Not Given";
                }
                if ($invoice_value[$k] == "") {
                    $invoice_value[$k] = "0";
                }
                if ($taxable_value[$k] == "") {
                    $taxable_value[$k] = "0";
                }
                if ($igst[$k] == "") {
                    $igst[$k] = "0";
                }
                if ($cgst[$k] == "") {
                    $cgst[$k] = "0";
                }
                if ($sgst[$k] == "") {
                    $sgst[$k] = "0";
                }
                if ($cess[$k] == "") {
                    $cess[$k] = "0";
                }

                $query = ("insert into invoice_not_included_gstr1 (`customer_id`,`insert_id`,`original_month`,`showing_month`,"
                        . "`category`,`gstin_no`,`invoice_date`,`invoice_no`,`name`,`invoice_value`,`taxable_value`,`igst`,`cgst`,`sgst`,`cess`)"
                        . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $this->db2->query($query, array($customer_id, $insert_id, $original_month[$k], $showing_month[$k], $category[$k], $gstin_arr[$k],
                    $invoice_date[$k], $invoice_no[$k], $name[$k], $invoice_value[$k], $taxable_value[$k], $igst[$k], $cgst[$k], $sgst[$k], $cess[$k]));
//                if ($this->db2->affected_rows() > 0) {
////                    echo'yes';
//                } else {
////                    echo'no';
//                }
            }
        }
        return $without_invoice;
    }

//function for invoice ammend summary

    public function invoice_ammend_summary_function($path6, $invoice_ammend) {
        $object = PHPExcel_IOFactory::load($path6);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $customer_id = $this->input->post("cust_id");
        $insert_id = $this->generate_insert_id();
        $customer_file_years = $this->input->post('customer_file_years');
        $original_month = array();
        $include_month = array();
        $amendment_month = array();
        $category = array();
        $gstin_arr = array();
        $invoice_date = array();
        $invoice_no = array();
        $name = array();
        $invoice_value = array();
        $taxable_value = array();
        $igst = array();
        $cgst = array();
        $sgst = array();
        $cess = array();
        $abc2 = $object->getActiveSheet()->getCell('A' . 3)->getValue();
        $x = filter_var($abc2, FILTER_SANITIZE_NUMBER_INT);
        $a1 = chunk_split($x, 4, "-");
        $a2 = rtrim($a1, '-');
//        exit;
        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        } else if ($customer_file_years == $a2) {
            for ($i = 0; $i <= $highestRow; $i++) {
                if ($object->getActiveSheet()->getCell("B" . $i)->getValue() == "Original Month") { //get records of origial month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $og_mon = $object->getActiveSheet()->getCell("B" . $j)->getValue();
                        $original_month[] = $og_mon;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("C" . $i)->getValue() == "Include in month") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $show_mon = $object->getActiveSheet()->getCell("C" . $j)->getValue();
                        $include_month[] = $show_mon;
                    }
                } else {
                    
                } if ($object->getActiveSheet()->getCell("D" . $i)->getValue() == "Amendment in month") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $amend_mon = $object->getActiveSheet()->getCell("D" . $j)->getValue();
                        $amendment_month[] = $amend_mon;
                    }
                } else {
                    
                }

                if ($object->getActiveSheet()->getCell("E" . $i)->getValue() == "Category") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cat = $object->getActiveSheet()->getCell("E" . $j)->getValue();
                        $category[] = $cat;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("F" . $i)->getValue() == "GSTIN") { //get records of GSTIN
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $gstin = $object->getActiveSheet()->getCell("F" . $j)->getValue();
                        $gstin_arr[] = $gstin;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("G" . $i)->getValue() == "Invoice Date") { //get records of Invoice Date
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceDate = $object->getActiveSheet()->getCell("G" . $j)->getValue();
                        $invoice_date[] = $invoiceDate;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("H" . $i)->getValue() == "Invoice No") { //get records of Invoice No
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoiceno = $object->getActiveSheet()->getCell("H" . $j)->getValue();
                        $invoice_no[] = $invoiceno;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("I" . $i)->getValue() == "Name") { //get records of Names
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $names = $object->getActiveSheet()->getCell("I" . $j)->getValue();
                        $name[] = $names;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("J" . $i)->getValue() == "Invoice Value ") { //get records of Invoice Value 
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $invoice_val = $object->getActiveSheet()->getCell("J" . $j)->getValue();
                        $invoice_value[] = $invoice_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("K" . $i)->getValue() == "Taxable Value") { //get records of Showing month
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $tax_val = $object->getActiveSheet()->getCell("K" . $j)->getValue();
                        $taxable_value[] = $tax_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("L" . $i)->getValue() == "IGST") { //get records of IGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $igst_val = $object->getActiveSheet()->getCell("L" . $j)->getValue();
                        $igst[] = $igst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("M" . $i)->getValue() == "CGST") { //get records of CGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cgst_val = $object->getActiveSheet()->getCell("M" . $j)->getValue();
                        $cgst[] = $cgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("N" . $i)->getValue() == "SGST") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $sgst_val = $object->getActiveSheet()->getCell("N" . $j)->getValue();
                        $sgst[] = $sgst_val;
                    }
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell("O" . $i)->getValue() == "CESS") { //get records of SGST
                    for ($j = $i + 1; $j <= $highestRow; $j++) {
                        $cess_val = $object->getActiveSheet()->getCell("O" . $j)->getValue();
                        $cess[] = $cess_val;
                    }
                } else {
                    
                }
            }
        } else {
            $response['id'] = 'file_ex_invoice_amend';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
            echo json_encode($response);
            exit;
        }


        $count = count($original_month);
        $query = $this->db2->query("SELECT * FROM `invoices_amended_summary_all` where customer_id='$customer_id'");
        if ($this->db2->affected_rows() > 0) {
            $monthly_history = $this->insert_invoice_ammend_summary_history($customer_id);
            if ($monthly_history == true) {
                for ($k = 0; $k < $count; $k++) {

                    if ($original_month[$k] == "") {
                        $original_month[$k] = "0";
                    }
                    if ($include_month[$k] == "") {
                        $include_month[$k] = "0";
                    }
                    if ($amendment_month[$k] == "") {
                        $amendment_month[$k] = "0";
                    }
                    if ($category[$k] == "") {
                        $category[$k] = "0";
                    }
                    if ($gstin_arr[$k] == "") {
                        $gstin_arr[$k] = "0";
                    }
                    if ($invoice_date[$k] == "") {
                        $invoice_date[$k] = "0";
                    }
                    if ($invoice_no[$k] == "") {
                        $invoice_no[$k] = "0";
                    }
                    if ($name[$k] == "") {
                        $name[$k] = "Not Given";
                    }
                    if ($invoice_value[$k] == "") {
                        $invoice_value[$k] = "0";
                    }
                    if ($taxable_value[$k] == "") {
                        $taxable_value[$k] = "0";
                    }
                    if ($igst[$k] == "") {
                        $igst[$k] = "0";
                    }
                    if ($cgst[$k] == "") {
                        $cgst[$k] = "0";
                    }
                    if ($sgst[$k] == "") {
                        $sgst[$k] = "0";
                    }
                    if ($cess[$k] == "") {
                        $cess[$k] = "0";
                    }

                    $query = ("insert into invoices_amended_summary_all (`customer_id`,`insert_id`,`original_month`,`included_in_month`,`amendment_month`,"
                            . "`category`,`gstin_no`,`invoice_date`,`invoice_no`,`name`,`invoice_value`,`taxable_value`,`igst`,`cgst`,`sgst`,`cess`)"
                            . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
                    $this->db2->query($query, array($customer_id, $insert_id, $original_month[$k], $include_month[$k], $amendment_month[$k], $category[$k], $gstin_arr[$k],
                        $invoice_date[$k], $invoice_no[$k], $name[$k], $invoice_value[$k], $taxable_value[$k], $igst[$k], $cgst[$k], $sgst[$k], $cess[$k]));
                    if ($this->db2->affected_rows() > 0) {
                        $invoice_ammend++;
                    }
                }
            }
        } else {
            for ($k = 0; $k < $count; $k++) {

                if ($original_month[$k] == "") {
                    $original_month[$k] = "0";
                }
                if ($include_month[$k] == "") {
                    $include_month[$k] = "0";
                }
                if ($amendment_month[$k] == "") {
                    $amendment_month[$k] = "0";
                }
                if ($category[$k] == "") {
                    $category[$k] = "0";
                }
                if ($gstin_arr[$k] == "") {
                    $gstin_arr[$k] = "0";
                }
                if ($invoice_date[$k] == "") {
                    $invoice_date[$k] = "0";
                }
                if ($invoice_no[$k] == "") {
                    $invoice_no[$k] = "0";
                }
                if ($name[$k] == "") {
                    $name[$k] = "Not Given";
                }
                if ($invoice_value[$k] == "") {
                    $invoice_value[$k] = "0";
                }
                if ($taxable_value[$k] == "") {
                    $taxable_value[$k] = "0";
                }
                if ($igst[$k] == "") {
                    $igst[$k] = "0";
                }
                if ($cgst[$k] == "") {
                    $cgst[$k] = "0";
                }
                if ($sgst[$k] == "") {
                    $sgst[$k] = "0";
                }
                if ($cess[$k] == "") {
                    $cess[$k] = "0";
                }

                $query = ("insert into invoices_amended_summary_all (`customer_id`,`insert_id`,`original_month`,`included_in_month`,`amendment_month`,"
                        . "`category`,`gstin_no`,`invoice_date`,`invoice_no`,`name`,`invoice_value`,`taxable_value`,`igst`,`cgst`,`sgst`,`cess`)"
                        . "values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
                $this->db2->query($query, array($customer_id, $insert_id, $original_month[$k], $include_month[$k], $amendment_month[$k], $category[$k], $gstin_arr[$k],
                    $invoice_date[$k], $invoice_no[$k], $name[$k], $invoice_value[$k], $taxable_value[$k], $igst[$k], $cgst[$k], $sgst[$k], $cess[$k]));
                if ($this->db2->affected_rows() > 0) {
                    $invoice_ammend++;
                }
            }
        }
        return $invoice_ammend;
    }

//function for return filled summary for GSTR1
    public function return_filled_summary_function($path7, $return_filled_GSTR1) {
        $object = PHPExcel_IOFactory::load($path7);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $customer_id = $this->input->post("cust_id");
        $customer_file_years = $this->input->post('customer_file_years');
        $insert_id = $this->generate_insert_id();
        $abc2 = $object->getActiveSheet()->getCell('B' . 2)->getValue();
//        $a = (explode(" . ", $abc2));
        $a = filter_var($abc2, FILTER_SANITIZE_NUMBER_INT);
        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        } else if ($customer_file_years == $a) {
            if ($object->getActiveSheet()->getCell('A' . 3)->getValue()) {
                $period = array();
                $status1 = array();
                $filling_date1 = array();
                $acknowledge_no1 = array();
                for ($l = 5; $l <= 13; $l++) {
                    $period[] = $object->getActiveSheet()->getCell('A' . $l)->getValue();
                    $status = $object->getActiveSheet()->getCell('B' . $l)->getValue();
                    $status1[] = $status;
                    $filling_date = $object->getActiveSheet()->getCell('C' . $l)->getValue();
                    $old_date_timestamp = strtotime($filling_date);
                    $filling_date1[] = date('Y-m-d', $old_date_timestamp);
                    $acknowledge_no = $object->getActiveSheet()->getCell('D' . $l)->getValue();
                    $acknowledge_no1[] = $acknowledge_no;
                }
            } else {
//           
            }
        } else {
            $response['id'] = 'file_word_database';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
//            $response['id'] = 'customer_file_years';
//             $response['error'] = 'Please Choose the year';
            echo json_encode($response);
            exit;
        }
        $count = count($period);

        $query = $this->db2->query("SELECT * FROM `return_filled_gstr1_summary` where customer_id='$customer_id'");
        if ($this->db2->affected_rows() > 0) {
            $offset_history = $this->insert_return_filled_summary_history($customer_id);
            if ($offset_history == true) {
                for ($m = 0; $m < $count; $m++) {
                    if ($period[$m] == "") {
                        $period[$m] = "0";
                    }
                    if ($status1[$m] == "") {
                        $status1[$m] = "0";
                    }
                    if ($filling_date1[$m] == "") {
                        $filling_date1[$m] = "0";
                    } if ($acknowledge_no1[$m] == "") {
                        $acknowledge_no1[$m] = "0";
                    }
                    $this->db2->query("insert into return_filled_GSTR1_summary (`insert_id`,`customer_id`,`period`,`status`,`filling_date`,`acknowledge_no`)"
                            . " values ('$insert_id','$customer_id','$period[$m]','$status1[$m]','$filling_date1[$m]','$acknowledge_no1[$m]')");

                    if ($this->db2->affected_rows() > 0) {
                        $return_filled_GSTR1++;
                    }
                }
            }
        } else {
            for ($m = 0; $m < $count; $m++) {
                if ($period[$m] == "") {
                    $period[$m] = "0";
                }
                if ($status1[$m] == "") {
                    $status1[$m] = "0";
                }
                if ($filling_date1[$m] == "") {
                    $filling_date1[$m] = "0";
                } if ($acknowledge_no1[$m] == "") {
                    $acknowledge_no1[$m] = "0";
                }
                $this->db2->query("insert into return_filled_GSTR1_summary (`insert_id`,`customer_id`,`period`,`status`,`filling_date`,`acknowledge_no`)"
                        . " values ('$insert_id','$customer_id','$period[$m]','$status1[$m]','$filling_date1[$m]','$acknowledge_no1[$m]')");
//                var_dump($query);
                if ($this->db2->affected_rows() > 0) {
                    $return_filled_GSTR1++;
                }
            }
        }
        return $return_filled_GSTR1;
        exit;
    }

//function for comparison summary of GSTR1 VS GSTR-3B

    public function compare_summary_function($path2, $compare_val) {
        $x = "A";
        $object = PHPExcel_IOFactory::load($path2);
        $worksheet = $object->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();
        $highestColumn = $worksheet->getHighestColumn();
        $i = 1;
        $abc = 0;
        $month_name = array();
        $gstr_3b = array();
        $gstr_1 = array();
        $gstr_1_ammend = array();
        $ammend_diff1 = array();
        $cummulative_diff_1 = array();
        $gstr_3b_2a = array();
        $gstr_2a = array();
        $gstr_Difference_2a = array();
        $cumm_diff_2a = array();

        $customer_id = $this->input->post('cust_id');

        $customer_file_years = $this->input->post('customer_file_years');

        $abcl = $object->getActiveSheet()->getCell('A' . 2)->getValue();
//        echo $abcl;
//        echo strlen("$abcl");
        $a = (explode(" ", $abcl));
//        print_r($a);
        $a1 = rtrim($a[10], '.');
        if ($customer_file_years == "") {
            $response['id'] = 'customer_file_years';
            $response['error'] = 'Please Select year';
            echo json_encode($response);
            exit;
        } else if ($customer_file_years == $a1) {
//       
            for ($row = 21; $row <= $highestRow; $row++) {

                $row_next = $row + 1;

                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-3B" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "GSTR-1") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr3b = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr3b = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr3b = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_3b[] = $IGST_gstr3b + $CGST_gstr3b + $SGST_gstr3b;
                    $row_month = $row - 3;
                    $month_name[] = $object->getActiveSheet()->getCell($x . $row_month)->getValue();
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-1") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1 = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1 = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1 = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_1[] = $IGST_gstr1 + $CGST_gstr1 + $SGST_gstr1;
                } else {
                    
                }

                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-1 Amend(Difference)") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1_ammend = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_1_ammend[] = $IGST_gstr1_ammend + $CGST_gstr1_ammend + $SGST_gstr1_ammend;
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "(3B - (GSTR-1 + Amend)) Difference") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1_ammend_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $ammend_diff1[] = $IGST_gstr1_ammend_diff + $CGST_gstr1_ammend_diff + $SGST_gstr1_ammend_diff;
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "Cumulative Difference" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "4 Eligible ITC") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr1_ammend_cummu_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $cummulative_diff_1[] = $IGST_gstr1_ammend_cummu_diff + $CGST_gstr1_ammend_cummu_diff + $SGST_gstr1_ammend_cummu_diff;

                    $i++;
                    $count = $i - 1;
                }
            }
            for ($row = 26; $row <= $highestRow; $row++) {
                $row_next = $row + 1;
                $row_prev = $row - 1;
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "4 Eligible ITC" && $object->getActiveSheet()->getCell($x . $row_next)->getValue() == "GSTR-3B") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);

                    $IGST_gstr3b = $object->getActiveSheet()->getCell($col_IGST . $row_next)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr3b = $object->getActiveSheet()->getCell($col_CGST . $row_next)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr3b = $object->getActiveSheet()->getCell($col_SGST . $row_next)->getValue();
                    $gstr_3b_2a[] = $IGST_gstr3b + $CGST_gstr3b + $SGST_gstr3b;
                    $row_month = $row - 8;
// $month_name = $object->getActiveSheet()->getCell($x . $row_month)->getValue();
                } else {
                    
                }

                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "GSTR-2A") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_gstr2a = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_gstr2a = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_gstr2a = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_2a[] = $IGST_gstr2a + $CGST_gstr2a + $SGST_gstr2a;
                } else {
                    
                }

                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "Difference") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_Difference = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_Difference = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_Difference = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $gstr_Difference_2a[] = $IGST_Difference + $CGST_Difference + $SGST_Difference;
                } else {
                    
                }
                if ($object->getActiveSheet()->getCell($x . $row)->getValue() == "Cumulative Difference" && $object->getActiveSheet()->getCell($x . $row_prev)->getValue() == "Difference") {
                    $ascii = ord($x);
                    $ascii += 2;
                    $col_IGST = chr($ascii);
                    $IGST_cumm_diff = $object->getActiveSheet()->getCell($col_IGST . $row)->getValue();

                    $ascii_cgst = ord($x);
                    $ascii_cgst += 3;
                    $col_CGST = chr($ascii_cgst);
                    $CGST_cumm_diff = $object->getActiveSheet()->getCell($col_CGST . $row)->getValue();

                    $ascii_sgst = ord($x);
                    $ascii_sgst += 3;
                    $col_SGST = chr($ascii_sgst);
                    $SGST_cumm_diff = $object->getActiveSheet()->getCell($col_SGST . $row)->getValue();
                    $cumm_diff_2a[] = $IGST_cumm_diff + $CGST_cumm_diff + $SGST_cumm_diff;

                    $count = $i;
                    $i++;
                } else {
                    
                }

//            
            }
        } else {
            $response['id'] = 'file_ex_compare';
            $response['error'] = 'Year is mismatch with file.Please choose correct.';
            echo json_encode($response);
            exit;
        }


        $insert_id = $this->generate_insert_id();
        $count = count($month_name);
        $query = $this->db2->query("SELECT * FROM `comparison_summary_all` where customer_id='$customer_id'");
        if ($this->db2->affected_rows() > 0) {
            $comparison_history = $this->insert_comparison_summary_history($customer_id);
            if ($comparison_history == true) {
                for ($i = 0; $i < $count; $i++) {
                    $query_insert_compare = $this->db2->query("insert into `comparison_summary_all` (`customer_id`,`insert_id`,`month`,`gstr1_3B`,`gstr1`,`gstr1_ammend`,`gstr1_difference`,`gstr1_cummulative`,"
                            . "`gstr2A_3B`,`gstr2A`,`gstr2A_difference`,`gstr2A_cummulative`) values"
                            . "('$customer_id','$insert_id','$month_name[$i]','$gstr_3b[$i]','$gstr_1[$i]','$gstr_1_ammend[$i]','$ammend_diff1[$i]','$cummulative_diff_1[$i]','$gstr_3b_2a[$i]','$gstr_2a[$i]','$gstr_Difference_2a[$i]','$cumm_diff_2a[$i]') ");

                    if ($this->db2->affected_rows() > 0) {
                        $compare_val++;
                    }
                }
            }
        } else {
            for ($i = 0; $i < $count; $i++) {
                $query_insert_compare = $this->db2->query("insert into `comparison_summary_all` (`customer_id`,`insert_id`,`month`,`gstr1_3B`,`gstr1`,`gstr1_ammend`,`gstr1_difference`,`gstr1_cummulative`,"
                        . "`gstr2A_3B`,`gstr2A`,`gstr2A_difference`,`gstr2A_cummulative`) values"
                        . "('$customer_id','$insert_id','$month_name[$i]','$gstr_3b[$i]','$gstr_1[$i]','$gstr_1_ammend[$i]','$ammend_diff1[$i]','$cummulative_diff_1[$i]','$gstr_3b_2a[$i]','$gstr_2a[$i]','$gstr_Difference_2a[$i]','$cumm_diff_2a[$i]') ");

                if ($this->db2->affected_rows() > 0) {
                    $compare_val++;
                }
            }
        }
        return $compare_val;
    }

//function for generate insert id

    public function generate_insert_id() {
        $result = $this->db2->query("SELECT insert_id FROM `insert_header_all` ORDER BY insert_id DESC LIMIT 0,1");
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $insert_id = $data->insert_id;
//generate user_id
            $insert_id = str_pad( ++$insert_id, 5, '0', STR_PAD_LEFT);
            return $insert_id;
        } else {
            $insert_id = 'insert_1001';
            return $insert_id;
        }
    }

//function for storing data to insert header all table

    public function insert_header_function($monthly_file, $threeb_offset_file, $comparison_file, $reconcillation_file, $state_wise_file, $without_invoice_file, $invoice_ammend_file, $return_filled_gstr1_file) {
        $created_on = date('y-m-d h:i:s');
        $updated_on = date('y-m-d h:i:s');
        $created_by = $this->input->post('user_name');
        $customer_id = $this->input->post('cust_id');
        $year_id = $this->input->post('customer_file_years');
        $insert_id = $this->generate_insert_id();
//in insert table this customer id is present?
        $result = $this->db2->query("SELECT * FROM `insert_header_all` where customer_id='$customer_id' and year_id='$year_id'");
        if ($result->num_rows() > 0) {
            $record = $result->row();
            $reconcillation_file_new = $record->reconcillation_file;
            if ($reconcillation_file != "") {
                $reconcillation_file_new = ($reconcillation_file_new + 1);
            }
            $comparison_file_new = $record->comparison_file;
            if ($comparison_file != "") {
                $comparison_file_new = ($comparison_file_new + 1);
            }
            $threeb_offset_file_new = $record->tb_offset_file;
            if ($threeb_offset_file != "") {
                $threeb_offset_file_new = ($threeb_offset_file_new + 1);
            }
            $monthly_file_new = $record->monthly_file;
            if ($monthly_file != "") {
                $monthly_file_new = ($monthly_file_new + 1);
            }
            $state_wise_new = $record->state_wise_file;
            if ($state_wise_file != "") {
                $state_wise_new = ($state_wise_new + 1);
            }

            $without_invoice_new = $record->without_invoice_GSTR1;
            if ($without_invoice_file != "") {
                $without_invoice_new = ($without_invoice_new + 1);
            }

            $invoice_ammend_new = $record->invoice_ammend_file;
            if ($invoice_ammend_file != "") {
                $invoice_ammend_new = ($invoice_ammend_new + 1);
            }

            $return_filled_new = $record->return_filled_summary;
            if ($return_filled_gstr1_file != "") {
                $return_filled_new = ($return_filled_new + 1);
            }



            $data = array(
                'monthly_file' => $monthly_file_new,
                'tb_offset_file' => $threeb_offset_file_new,
                'comparison_file' => $comparison_file_new,
                'reconcillation_file' => $reconcillation_file_new,
                'state_wise_file' => $state_wise_new,
                'without_invoice_GSTR1' => $without_invoice_new,
                'invoice_ammend_file' => $invoice_ammend_new,
                'return_filled_summary' => $return_filled_new
            );

            $this->db2->where("customer_id='$customer_id'");
            $this->db2->where("year_id='$year_id'");
            $this->db2->update('insert_header_all', $data);
        } else {
//            
            if ($reconcillation_file != "") {
                $reconcillation_file_new = 1;
            } else {
                $reconcillation_file_new = 0;
            }

            if ($comparison_file != "") {
                $comparison_file_new = 1;
            } else {
                $comparison_file_new = 0;
            }

            if ($threeb_offset_file != "") {
                $threeb_offset_file_new = 1;
            } else {
                $threeb_offset_file_new = 0;
            }

            if ($monthly_file != "") {
                $monthly_file_new = 1;
            } else {
                $monthly_file_new = 0;
            }

            if ($state_wise_file != "") {
                $state_wise_new = 1;
            } else {
                $state_wise_new = 0;
            }
            if ($without_invoice_file != "") {
                $without_invoice_new = 1;
            } else {
                $without_invoice_new = 0;
            }
            if ($invoice_ammend_file != "") {
                $invoice_ammend_new = 1;
            } else {
                $invoice_ammend_new = 0;
            }

            if ($return_filled_gstr1_file != "") {
                $return_filled_new = 1;
            } else {
                $return_filled_new = 0;
            }

            $this->db2->query("insert into `insert_header_all`(`insert_id`,`customer_id`,`year_id`,`monthly_file`,`tb_offset_file`,`comparison_file`,`reconcillation_file`,`state_wise_file`,`without_invoice_GSTR1`,`invoice_ammend_file`,`return_filled_summary`,`created_on`,`created_by`,`updated_on`"
                    . ") values"
                    . "('$insert_id','$customer_id','$year_id','$monthly_file_new','$threeb_offset_file_new','$comparison_file_new','$reconcillation_file_new','$state_wise_new','$without_invoice_new','$invoice_ammend_new','$return_filled_new','$created_on','$created_by','$updated_on')");

            if ($this->db2->affected_rows() > 0) {
//                echo"insert";
            }
        }
    }

//function for generate archieve id for monthly_history table

    public function generate_archieve_monthly_id() {
        $result = $this->db2->query("SELECT archive_id FROM `monthly_summary_history_all` ORDER BY archive_id DESC LIMIT 0,1");
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $archieve_id = $data->archive_id;
//generate user_id
            $archieve_id = str_pad( ++$archieve_id, 5, '0', STR_PAD_LEFT);
            return $archieve_id;
        } else {
            $archieve_id = 'archieve_1001';
            return $archieve_id;
        }
    }

//function for storing monthly_summary_all data into history table

    public function insert_monthly_summary_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `monthly_summary_all` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archive_id = $this->generate_archieve_monthly_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archive_id' => $archive_id,
                    'month' => $row->month,
                    'inter_state_supply' => $row->inter_state_supply,
                    'intra_state_supply' => $row->intra_state_supply,
                    'no_gst_paid_supply' => $row->no_gst_paid_supply,
                    'debit_value' => $row->debit_value,
                    'credit_value' => $row->credit_value,
                    'sub_total_non_gst' => $row->sub_total_non_gst,
                    'sub_total_exempt' => $row->sub_total_exempt,
                    'tax_inter_state' => $row->tax_inter_state,
                    'tax_intra_state' => $row->tax_intra_state,
                    'tax_debit' => $row->tax_debit,
                    'tax_credit' => $row->tax_credit,
                    'interstate_b2b' => $row->interstate_b2b,
                    'intrastate_b2b' => $row->intrastate_b2b,
                    'interstate_b2c' => $row->interstate_b2c,
                    'intrastate_b2c' => $row->intrastate_b2c,
                    'credit_b2b' => $row->credit_b2b,
                    'credit_b2c' => $row->credit_b2c,
                    'debit_b2c' => $row->debit_b2c,
                    'total_taxable_advance_no_invoice' => $row->total_taxable_advance_no_invoice,
                    'total_tax_advance_no_invoice' => $row->total_tax_advance_no_invoice,
                    'total_taxable_advance_invoice' => $row->total_taxable_advance_invoice,
                    'total_tax_advance_invoice' => $row->total_tax_advance_invoice,
                    'advance_invoice_not_issue_b2b' => $row->advance_invoice_not_issue_b2b,
                    'advance_invoice_issue_b2b' => $row->advance_invoice_issue_b2b,
                    'total_taxable_data_gst_export' => $row->total_taxable_data_gst_export,
                    'total_tax_data_gst_export' => $row->total_tax_data_gst_export,
                    'total_non_gst_export' => $row->total_non_gst_export,
                    'advance_invoice_not_issue_b2c' => $row->advance_invoice_not_issue_b2c,
                    'advance_invoice_issue_b2c' => $row->advance_invoice_issue_b2c,
                    'sub_total_nil_rated' => $row->sub_total_nil_rated,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('monthly_summary_history_all', $data);
            }
            if ($res == true) {

                $this->db2->where('customer_id', $customer_id)
                        ->delete('monthly_summary_all');
                return true;
//                  $query = $this->db->delete('monthly_summary_all');
            }
        }
    }

//function for generate archieve id for 3B offset summary history

    public function generate_archieve_3boffset_id() {
        $result = $this->db2->query("SELECT archieve_id FROM `3b_offset_summary_history_all` ORDER BY archieve_id DESC LIMIT 0,1");
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $archieve_id = $data->archieve_id;
//generate user_id
            $archieve_id = str_pad( ++$archieve_id, 5, '0', STR_PAD_LEFT);
            return $archieve_id;
        } else {
            $archieve_id = 'archieve_1001';
            return $archieve_id;
        }
    }

//function for storing 3B-offset  data into history table

    public function insert_3boffset_summary_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `3b_offset_summary_all` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archieve_id = $this->generate_archieve_3boffset_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'month' => $row->month,
                    'outward_liability' => $row->outward_liability,
                    'rcb_liablity' => $row->rcb_liablity,
                    'ineligible_itc' => $row->ineligible_itc,
                    'net_itc' => $row->net_itc,
                    'paid_in_credit' => $row->paid_in_credit,
                    'paid_in_cash' => $row->paid_in_cash,
                    'interest_late_fee' => $row->interest_late_fee,
                    'debit' => $row->debit,
                    'debit_net_itc' => $row->debit_net_itc,
                    'late_fees' => $row->late_fees,
                    'due_date' => $row->due_date,
                    'filling_date' => $row->filling_date,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('3b_offset_summary_history_all', $data);
            }
            if ($res == true) {

                $this->db2->where('customer_id', $customer_id)
                        ->delete('3b_offset_summary_all');
                return true;
//                  $query = $this->db->delete('monthly_summary_all');
            }
        }
    }

//function for generate archieve id for comparison summary history

    public function generate_archieve_comparison_id() {
        $result = $this->db2->query("SELECT archieve_id FROM `comparison_summary_history_all` ORDER BY archieve_id DESC LIMIT 0,1");
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $archieve_id = $data->archieve_id;
//generate user_id
            $archieve_id = str_pad( ++$archieve_id, 5, '0', STR_PAD_LEFT);
            return $archieve_id;
        } else {
            $archieve_id = 'archieve_1001';
            return $archieve_id;
        }
    }

//function for storing comparison_summary_all data into history table

    public function insert_comparison_summary_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `comparison_summary_all` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archieve_id = $this->generate_archieve_comparison_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'month' => $row->month,
                    'gstr1_3B' => $row->gstr1_3B,
                    'gstr1' => $row->gstr1,
                    'gstr1_ammend' => $row->gstr1_ammend,
                    'gstr1_difference' => $row->gstr1_difference,
                    'gstr1_cummulative' => $row->gstr1_cummulative,
                    'gstr2A_3B' => $row->gstr2A_3B,
                    'gstr2A' => $row->gstr2A,
                    'gstr2A_difference' => $row->gstr2A_difference,
                    'gstr2A_cummulative' => $row->gstr2A_cummulative,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('comparison_summary_history_all', $data);
            }
            if ($res == true) {

                $this->db2->where('customer_id', $customer_id)
                        ->delete('comparison_summary_all');
                return true;
//                  $query = $this->db->delete('monthly_summary_all');
            }
        }
    }

//function for generate archieve id for Reconcillation summary history

    public function generate_archieve_reconcillation_id() {
        $result = $this->db2->query("SELECT archieve_id FROM `gstr_2a_reconciliation_history_all` ORDER BY archieve_id DESC LIMIT 0,1");
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $archieve_id = $data->archieve_id;
//generate user_id
            $archieve_id = str_pad( ++$archieve_id, 5, '0', STR_PAD_LEFT);
            return $archieve_id;
        } else {
            $archieve_id = 'archieve_1001';
            return $archieve_id;
        }
    }

//function for storing reconcillation_summary_all data into history table

    public function insert_reconcillation_summary_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `gstr_2a_reconciliation_all` where customer_id='$customer_id'");
        $archieve_id = $this->generate_archieve_reconcillation_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'status' => $row->status,
                    'company_name' => $row->company_name,
                    'period' => $row->period,
                    'invoice_no' => $row->invoice_no,
                    'place_of_supply' => $row->place_of_supply,
                    'invoice_date' => $row->invoice_date,
                    'invoice_value' => $row->invoice_value,
                    'taxable_value' => $row->taxable_value,
                    'tax' => $row->tax,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('gstr_2a_reconciliation_history_all', $data);
            }
        } else {
            
        }
        if ($res == true) {

            $this->db2->where('customer_id', $customer_id)
                    ->delete('gstr_2a_reconciliation_all');
            return true;
//                  $query = $this->db->delete('monthly_summary_all');
        }
    }

//function for generate acrchive id for reconcillation partial match history

    public function generate_archieve_reconcill_partially_id() {
        $result = $this->db2->query("SELECT archieve_id FROM `gstr_2a_reconciliation_partially_match_summary_history` ORDER BY archieve_id DESC LIMIT 0,1");
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $archieve_id = $data->archieve_id;
//generate user_id
            $archieve_id = str_pad( ++$archieve_id, 5, '0', STR_PAD_LEFT);
            return $archieve_id;
        } else {
            $archieve_id = 'archieve_1001';
            return $archieve_id;
        }
    }

//function for storing reconcillation_partial_summary_all data into history table

    public function insert_reconcillation_partial_summary_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `gstr_2a_reconciliation_partially_match_summary` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archieve_id = $this->generate_archieve_reconcill_partially_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'company_name' => $row->company_name,
                    'status' => $row->status,
                    'period_apr' => $row->period_apr,
                    'invoice_no_apr' => $row->invoice_no_apr,
                    'place_of_supply_apr' => $row->place_of_supply_apr,
                    'period_2a' => $row->period_2a,
                    'invoice_no_2a' => $row->invoice_no_2a,
                    'place_of_supply_2a' => $row->place_of_supply_2a,
                    'taxable_value' => $row->taxable_value,
                    'tax' => $row->tax,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('gstr_2a_reconciliation_partially_match_summary_history', $data);
            }
        } else {
            
        }
        if ($res == true) {

            $this->db2->where('customer_id', $customer_id)
                    ->delete('gstr_2a_reconciliation_partially_match_summary');
            return true;
//                  $query = $this->db->delete('monthly_summary_all');
        }
    }

//function for generate acrchive id for state wise 

    public function generate_archieve_state_wise_id() {
        $result = $this->db2->query("SELECT archieve_id FROM `state_wise_summary_all_history` ORDER BY archieve_id DESC LIMIT 0,1");
        if ($result->num_rows() > 0) {
            $data = $result->row();
            $archieve_id = $data->archieve_id;
//generate user_id
            $archieve_id = str_pad( ++$archieve_id, 5, '0', STR_PAD_LEFT);
            return $archieve_id;
        } else {
            $archieve_id = 'archieve_1001';
            return $archieve_id;
        }
    }

//function for storing state_wise_history data into history table

    public function insert_state_wise_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `state_wise_summary_all` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archieve_id = $this->generate_archieve_state_wise_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'state_name' => $row->state_name,
                    'taxable_value' => $row->taxable_value,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('state_wise_summary_all_history', $data);
            }
            if ($res == true) {

                $this->db2->where('customer_id', $customer_id)
                        ->delete('state_wise_summary_all');
                return true;
//                  $query = $this->db->delete('monthly_summary_all');
            }
        }
    }

//function for storing without invoice data into history table

    public function insert_without_invoice_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `invoice_not_included_gstr1` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archieve_id = $this->generate_archieve_state_wise_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'original_month' => $row->original_month,
                    'showing_month' => $row->showing_month,
                    'category' => $row->category,
                    'gstin_no' => $row->gstin_no,
                    'invoice_date' => $row->invoice_date,
                    'invoice_no' => $row->invoice_no,
                    'name' => $row->name,
                    'invoice_value' => $row->invoice_value,
                    'taxable_value' => $row->taxable_value,
                    'igst' => $row->igst,
                    'cgst' => $row->cgst,
                    'sgst' => $row->sgst,
                    'cess' => $row->cess,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('invoice_not_included_gstr1_history', $data);
            }
            if ($res == true) {

                $this->db2->where('customer_id', $customer_id)
                        ->delete('invoice_not_included_gstr1');
                return true;
//                  $query = $this->db->delete('monthly_summary_all');
            }
        }
    }

//function for storing invoice ammend data into history table

    public function insert_invoice_ammend_summary_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `invoices_amended_summary_all` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archieve_id = $this->generate_archieve_state_wise_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'original_month' => $row->original_month,
                    'included_in_month' => $row->included_in_month,
                    'amendment_month' => $row->amendment_month,
                    'category' => $row->category,
                    'gstin_no' => $row->gstin_no,
                    'invoice_date' => $row->invoice_date,
                    'invoice_no' => $row->invoice_no,
                    'name' => $row->name,
                    'invoice_value' => $row->invoice_value,
                    'taxable_value' => $row->taxable_value,
                    'igst' => $row->igst,
                    'cgst' => $row->cgst,
                    'sgst' => $row->sgst,
                    'cess' => $row->cess,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('invoices_amended_summary_history_all', $data);
            }
            if ($res === true) {

                $this->db2->where('customer_id', $customer_id)
                        ->delete('invoices_amended_summary_all');
                return true;
//                  $query = $this->db->delete('monthly_summary_all');
            }
        }
    }

//function for return filled summary GSTR1

    public function insert_return_filled_summary_history($customer_id) {
        $query = $this->db2->query("SELECT * FROM `return_filled_gstr1_summary` where customer_id='$customer_id'");
//        $archive_id = 'archieve_1001';
        $archieve_id = $this->generate_archieve_state_wise_id();
        $updated_on = date('y-m-d h:i:s');
        if ($query->num_rows() > 0) {
            $record = $query->result();
            foreach ($record as $row) {
                $data = array(
                    'customer_id' => $row->customer_id,
                    'insert_id' => $row->insert_id,
                    'archieve_id' => $archieve_id,
                    'period' => $row->period,
                    'status' => $row->status,
                    'filling_date' => $row->filling_date,
                    'acknowledge_no' => $row->acknowledge_no,
                    'updated_on' => $updated_on,
                );

                $res = $this->db2->insert('return_filled_gstr1_summary_history', $data);
            }
            if ($res === true) {

                $this->db2->where('customer_id', $customer_id)
                        ->delete('return_filled_gstr1_summary');
                return true;
//                  $query = $this->db->delete('monthly_summary_all');
            }
        }
    }

//function to decrement column of excel
    public function getAlpha($highestColumn_row, $ord, $a, $index) {
        if ($ord >= 65) {
// The final character is still greater than A, decrement
            $highestColumn_row = substr($highestColumn_row, 0, $index) . chr($ord - 1);
        } else {
            if ($a == 2) {
                $highestColumn_row = 'Z';
            } else if ($a == 3) {
                $highestColumn_row = 'ZZ';
            } else if ($a == 1) {
                $highestColumn_row = 'A';
            }
        }
        return $highestColumn_row;
    }

//Function to get months of file

    public function get_months($months) {
        $cnt = count($months);
        $month_data = array();
        for ($a12 = 0; $a12 < $cnt; $a12++) {
            $month = $months[$a12];
            $month_data[] = $months[$a12];
            $a12 = ($a12 * 1 + 3);
        }
        return $month_data;
    }

    public function get_months2($months) {
        $cnt = count($months);
        $month_data = array();
        for ($a12 = 0; $a12 < $cnt; $a12++) {
            $month = $months[$a12];
            $month_data[] = $months[$a12];
            $a12 = ($a12 * 1 + 4);
        }
        return $month_data;
    }

//Function to get inter state values of file

    public function get_inter_state_total_fun($highestColumn_row, $i, $object) {
        $tax_inter_state = array();
        $data_arr1 = array();
        $highest_value_without_GT = $highestColumn_row; // got last value here for if

        $char = 'G';
        while ($char !== $highest_value_without_GT) {
            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values);

//For getting the value for tax inter state 
        $data_arr_inter = array();

        for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
            $Dr_values = $values[$a_dr];
            $data_arr_inter[] = $values[$a_dr];
        }
        $aa1 = array();
        for ($a_dr = 1; $a_dr < sizeof($values); $a_dr++) {

            if ($a_dr % 2 != 0) {

                $aa1[] = $values[$a_dr];
            }
        }
//            var_dump($aa1);

        $a1 = (sizeof($aa1));
        $a2 = $a1 % 1;
        $a3 = $a1 - $a2;
        for ($k = 0; $k < ($a3); $k = $k + 2) {
            $tax_inter_state[] = $aa1[$k] + $aa1[$k + 1];
        }
//        $cnt = count($values);

        for ($aa = 0; $aa < $cnt; $aa++) {
//            $data1 = $values[$aa];
            $data_arr1[] = $values[$aa];
            $aa = ($aa * 1 + 3);
        }
//        return $tax_inter_state;
        return array($data_arr1, $tax_inter_state);
    }

    public function get_inter_state_total_fun1($highestColumn_row, $i, $object) {

        $tax_inter_state = array();
        $data_arr1 = array();

        $highest_value_without_GT = $highestColumn_row; // got last value here for if

        $char = 'G';
        while ($char !== $highest_value_without_GT) {
            $values[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values);
//             exit;
//For getting the value for tax inter state 
        $data_arr_inter = array();

        for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
            $Dr_values = $values[$a_dr];
            $data_arr_inter[] = $values[$a_dr];
        }
        $aa1 = array();
//            echo sizeof($values);
        for ($a_dr = 1; $a_dr < $cnt; $a_dr++) {

            if ($a_dr % 2 != 0) {

                $aa1[] = $values[$a_dr];
            }
        }
        $a1 = (sizeof($aa1));
        $a2 = $a1 % 1;
        $a3 = $a1 - $a2;
        for ($k = 0; $k < ($a3); $k = $k + 2) {

            $tax_inter_state[] = $aa1[$k] + $aa1[$k + 1];
        }

//        $cnt = count($values);
        for ($aa = 0; $aa < $cnt; $aa++) {
//            $data1 = $values[$aa];
            $data_arr1[] = $values[$aa];
            $aa = ($aa * 1 + 3);
        }
//        return $tax_inter_state;
        return array($data_arr1, $tax_inter_state);
    }

//Function to get intra state values of file

    public function intrastate_b2b_fun($worksheet, $object, $i) {
        $highest_value = $worksheet->getHighestColumn($i); // got last value here for else
        for ($k = 0; $k < 4; $k++) {
            $a11 = strlen($highest_value);
            $index1 = strlen($highest_value) - 1;
            $ord1 = ord($highest_value[$index1]);
            $highestColumn_row_pp = $this->getAlpha($highest_value, $ord1, $a11, $index1);
            $highest_value = $highestColumn_row_pp;
        }
        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
        $char = 'G';
        $values1 = array();
        while ($char !== $highest_value_without_GT) {
            $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values1);
        $intrastate_b2b = array();
        for ($a12 = 0; $a12 < $cnt; $a12++) {
//                $data2 = $values1[$a12];
            $intrastate_b2b[] = $values1[$a12];
            $a12 = ($a12 * 1 + 3);
        }
//        var_dump($intrastate_b2b);

        return $intrastate_b2b;
    }

    public function intrastate_b2c_fun($worksheet, $object, $i, $highest_value) {

        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
        $char = 'G';
        $values1 = array();
        while ($char !== $highest_value_without_GT) {
            $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values1);
        $intrastate_b2b = array();
        for ($a12 = 0; $a12 < $cnt; $a12++) {
//                $data2 = $values1[$a12];
            $intrastate_b2b[] = $values1[$a12];
            $a12 = ($a12 * 1 + 3);
        }
        return $intrastate_b2b;
    }

//Function to get intra state total values of file

    public function get_intra_state_total($highest_value, $i, $object) {

        $tax_intra_state = array();
        $data_arr2 = array();

        $highest_value_without_GT = $highest_value; //hightest cloumn till where we have to find our data
        $char = 'G';
        while ($char !== $highest_value_without_GT) {
            $values1[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values1);

//For getting the tax intra state value
        $data_arr_intra = array();

        for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
            $Dr_values = $values1[$a_dr];
            $data_arr_intra[] = $values1[$a_dr];
        }
//                          
        $aa1 = array();
//        echo sizeof($values1);
        for ($a_dr = 1; $a_dr <= sizeof($values1); $a_dr++) {

            if ($a_dr % 4 != 0) {

                $aa1[] = $values1[$a_dr];
            }
        }
        $a1 = (sizeof($aa1));
        $a2 = $a1 % 3;
        $a3 = $a1 - $a2;
        for ($k = 0; $k < ($a3); $k = $k + 3) {
            $tax_intra_state[] = $aa1[$k] + $aa1[$k + 1] + $aa1[$k + 2];
        }

        for ($a12 = 0; $a12 < $cnt; $a12++) {
            $data2 = $values1[$a12];
            $data_arr2[] = $values1[$a12];
            $a12 = ($a12 * 1 + 3);
        }
        return array($data_arr2, $tax_intra_state);
    }

//Function to get sub total non gst values of file

    public function sub_total_non_gst($highestColumn_row_sbng, $object, $i) { //function to get SUB total NON GST and DATA of Exempt Supply
        $char = 'G';
        while ($char !== $highestColumn_row_sbng) {
            $values_SBNG[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt_sbng = count($values_SBNG);
        $data_arr31 = array();
        for ($ar1 = 0; $ar1 < $cnt_sbng; $ar1++) {
//            $data_non_gst = $values_SBNG[$ar1];
            $data_arr31[] = $values_SBNG[$ar1];
        }
        return $data_arr31;
    }

//Function to get no gst data values of file

    public function get_no_gst_data($highestColumn_row_ng, $char, $object, $i) { //function to get TOTAL NON GST data
        while ($char !== $highestColumn_row_ng) {
            $values_NG[] = $object->getActiveSheet()->getCell($char . $i)->getValue();

            $char++;
        }
        $cnt_ng = count($values_NG);
        $data_arr3 = array();
        for ($a12 = 0; $a12 < $cnt_ng; $a12++) {
//            $data_non_gst = $values_NG[$a12];
            $data_arr3[] = $values_NG[$a12];
        }
        return $data_arr3;
    }

//function for get credit data of file

    public function get_credit_data($i, $object, $highestRow, $worksheet) {
        $tax_credit_value = array();
        $data_arr5 = array();
        $m = 1;
        for ($j = $i; $j <= $highestRow; $j++) {
            if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Total") {
                $m++;
                $highestColumn_cr = $worksheet->getHighestColumn($j);
                for ($k = 0; $k < 4; $k++) {
                    $a11 = strlen($highestColumn_cr);
                    $index1 = strlen($highestColumn_cr) - 1;
                    $ord1 = ord($highestColumn_cr[$index1]);
                    $a1 = substr($highestColumn_cr, 0, 1);
                    $a2 = substr($highestColumn_cr, 1);
                    if ($a1 != $a2 and $a2 == "A") {
                        $ord = ord($highestColumn_cr[1]);
                        $index = 1;
                        $o1 = ord($a1);
                        $o2 = chr($o1 - 1);
                        $highestColumn_row_pp = $o2 . "Z";
                    } else {
                        $highestColumn_row_pp = $this->getAlpha($highestColumn_cr, $ord1, $a11, $index1);
                    }
                    $highestColumn_cr = $highestColumn_row_pp;
                }
                $highest_value_without_CR = $highestColumn_cr; //hightest cloumn till where we have to find our data
                $char = 'G';
                while ($char !== $highest_value_without_CR) {
                    $values_CR[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
                    $char++;
                }
                $cnt = count($values_CR);

                $data_credit_value = array();

                for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
                    $Dr_values = $values_CR[$a_dr];
                    $data_credit_value[] = $values_CR[$a_dr];
                }

                $aa3 = array();
                for ($a_dr = 1; $a_dr < $cnt; $a_dr++) {

                    if ($a_dr % 5 != 0) {

                        $aa3[] = $values_CR[$a_dr];
                    }
//                                var_dump($aa2);
                }
                $cntt = count($aa3);
                $a1 = sizeof($aa3);
                $a2 = $a1 % 4;
                $a3 = $a1 - $a2;
                for ($k = 0; $k < $a3; $k = $k + 4) {
                    $tax_credit_value[] = $aa3[$k] + $aa3[$k + 1] + $aa3[$k + 2] + $aa3[$k + 3];
                }

//                                var_dump($cnt);

                for ($a_cr = 0; $a_cr < $cnt; $a_cr++) {
                    $Cr_values = $values_CR[$a_cr];
                    $data_arr5[] = $values_CR[$a_cr];
                    $a_cr = ($a_cr * 1 + 4);
                }
            }
            if ($m > 1) {
                break;
            }
        }
        return array($data_arr5, $tax_credit_value);
    }

//function for get debit data of file

    public function get_debit_data($i, $object, $highestRow, $worksheet) {
        $tax_debit_value = array();
        $data_arr4 = array();
        for ($j = $i; $j <= $highestRow; $j++) {
            if ($object->getActiveSheet()->getCell('B' . $j)->getValue() == "Total") {
                $highestColumn_dr = $worksheet->getHighestColumn($j);
                for ($k = 0; $k < 4; $k++) {
                    $a11 = strlen($highestColumn_dr);
                    $index1 = strlen($highestColumn_dr) - 1;
                    $ord1 = ord($highestColumn_dr[$index1]);
                    $a1 = substr($highestColumn_dr, 0, 1);
                    $a2 = substr($highestColumn_dr, 1);
                    if ($a1 != $a2 and $a2 == "A") {
                        $ord = ord($highestColumn_dr[1]);
                        $index = 1;
                        $o1 = ord($a1);
                        $o2 = chr($o1 - 1);
                        $highestColumn_row_pp = $o2 . "Z";
                    } else {
                        $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
                    }
                    $highestColumn_dr = $highestColumn_row_pp;
                }

                $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
                $char = 'G';
                while ($char !== $highest_value_without_DR) {
                    $values_DR[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
                    $char++;
                }
                $cnt = count($values_DR);

//get the value for tax debit value

                $data_debit_value_tax = array();

                for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
                    $Dr_values = $values_DR[$a_dr];
                    $data_debit_value_tax[] = $values_DR[$a_dr];
                }

                $aa2 = array();
                for ($a_dr = 1; $a_dr < sizeof($values_DR); $a_dr++) {

                    if ($a_dr % 5 != 0) {

                        $aa2[] = $values_DR[$a_dr];
                    }
//                                var_dump($aa2);
                }
                $a1 = sizeof($aa2);
                $a2 = $a1 % 4;
                $a3 = $a1 - $a2;

                for ($k = 0; $k < $a3; $k = $k + 4) {
                    $tax_debit_value[] = $aa2[$k] + $aa2[$k + 1] + $aa2[$k + 2] + $aa2[$k + 3];
                }

                for ($a_dr = 0; $a_dr < $cnt; $a_dr++) {
//                    $Dr_values = $values_DR[$a_dr];
                    $data_arr4[] = $values_DR[$a_dr];
                    $a_dr = ($a_dr * 1 + 4);
                }
            }
        }

        return array($data_arr4, $tax_debit_value);
    }

    public function credit_b2b_fun($worksheet, $object, $i) {
        $highestColumn_dr = $worksheet->getHighestColumn($i);
        for ($k = 0; $k < 5; $k++) {
            $a11 = strlen($highestColumn_dr);
            $index1 = strlen($highestColumn_dr) - 1;
            $ord1 = ord($highestColumn_dr[$index1]);
            $a1 = substr($highestColumn_dr, 0, 1);
            $a2 = substr($highestColumn_dr, 1);
            if ($a1 != $a2 and $a2 == "A") {
                $ord = ord($highestColumn_dr[1]);
                $index = 1;
                $o1 = ord($a1);
                $o2 = chr($o1 - 1);
                $highestColumn_row_pp = $o2 . "Z";
            } else {
                $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
            }
            $highestColumn_dr = $highestColumn_row_pp;
        }

        $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
        $char = 'G';
        $values_CR = array();
        while ($char !== $highest_value_without_DR) {
            $values_CR[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt = count($values_CR);
        $credit_b2b = array();
        for ($a_dr1 = 0; $a_dr1 < $cnt; $a_dr1++) {
            $Dr_values = $values_CR[$a_dr1];
            $credit_b2b[] = $values_CR[$a_dr1];
            $a_dr1 = ($a_dr1 * 1 + 4);
        }
        return $credit_b2b;
    }

    public function debit_b2b_fun($worksheet, $object, $i) {
        $highestColumn_dr = $worksheet->getHighestColumn($i);
        for ($k = 0; $k < 5; $k++) {
            $a11 = strlen($highestColumn_dr);
            $index1 = strlen($highestColumn_dr) - 1;
            $ord1 = ord($highestColumn_dr[$index1]);
            $a1 = substr($highestColumn_dr, 0, 1);
            $a2 = substr($highestColumn_dr, 1);
            if ($a1 != $a2 and $a2 == "A") {
                $ord = ord($highestColumn_dr[1]);
                $index = 1;
                $o1 = ord($a1);
                $o2 = chr($o1 - 1);
                $highestColumn_row_pp = $o2 . "Z";
            } else {
                $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
            }
            $highestColumn_dr = $highestColumn_row_pp;
        }

        $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
        $char = 'G';
        $values_DR = array();
        while ($char !== $highest_value_without_DR) {
            $values_DR[] = $object->getActiveSheet()->getCell($char . $i)->getValue();
            $char++;
        }
        $cnt1 = count($values_DR);
        $debit_b2b = array();
        for ($a_cr1 = 0; $a_cr1 < $cnt1; $a_cr1++) {
            $Dr_values = $values_DR[$a_cr1];
            $debit_b2b[] = $values_DR[$a_cr1];
            $a_cr1 = ($a_cr1 * 1 + 4);
        }
        return $debit_b2b;
    }

    public function get_credit_debit_b2c($j, $worksheet, $object) {
        $highestColumn_dr = $worksheet->getHighestColumn($j);
        for ($k = 0; $k < 5; $k++) {
            $a11 = strlen($highestColumn_dr);
            $index1 = strlen($highestColumn_dr) - 1;
            $ord1 = ord($highestColumn_dr[$index1]);
            $a1 = substr($highestColumn_dr, 0, 1);
            $a2 = substr($highestColumn_dr, 1);
            if ($a1 != $a2 and $a2 == "A") {
                $ord = ord($highestColumn_dr[1]);
                $index = 1;
                $o1 = ord($a1);
                $o2 = chr($o1 - 1);
                $highestColumn_row_pp = $o2 . "Z";
            } else {
                $highestColumn_row_pp = $this->getAlpha($highestColumn_dr, $ord1, $a11, $index1);
            }
            $highestColumn_dr = $highestColumn_row_pp;
        }

        $highest_value_without_DR = $highestColumn_dr; //hightest cloumn till where we have to find our data
        $char = 'G';
        $cr_values = array();
        while ($char !== $highest_value_without_DR) {
            $cr_values[] = $object->getActiveSheet()->getCell($char . $j)->getValue();
            $char++;
        }
        $cnt = count($cr_values);
        $credit_b2c = array();
        for ($a_dr11 = 0; $a_dr11 < $cnt; $a_dr11++) {
            $cr_values1 = $cr_values[$a_dr11];
            $credit_b2c[] = $cr_values[$a_dr11];
            $a_dr11 = ($a_dr11 * 1 + 4);
        }
        return $credit_b2c;
    }

//Function for get selected file names when select the files for uploaded

    public function get_graph_names() {
        $monthly_file = $_FILES['file_ex1']['name'];
        $tboffset_file = $_FILES['file_ex2']['name'];
        $comparison_file = $_FILES['file_ex_compare']['name'];
        $file_ex_reconcill = $_FILES['file_ex_reconcill']['name'];
        $file_ex_state_wise = $_FILES['file_ex_state_wise']['name'];
        $file_ex_invoice = $_FILES['file_ex_withot_invoice']['name'];
        if ($monthly_file != "") {
            $response['message'] = 'success';
            $response['status_monthly'] = true;
        } else {
            $response['message'] = '';
            $response['status_monthly'] = false;
        } if ($tboffset_file != "") {
            $response['message'] = 'success';
            $response['status_3b_offset'] = true;
        } else {
            $response['message'] = '';
            $response['status_3b_offset'] = false;
        }
        if ($comparison_file != "") {

            $response['message'] = 'success';
            $response['status_filex_compare'] = true;
        } else {
            $response['message'] = '';
            $response['status_filex_compare'] = false;
        }
        if ($file_ex_reconcill != "") {
            $response['message'] = 'success';
            $response['status_filex_reconcill'] = true;
        } else {
            $response['message'] = '';
            $response['status_filex_reconcill'] = false;
        }
        if ($file_ex_state_wise != "") {
            $response['message'] = 'success';
            $response['status_filex_state_wise'] = true;
        } else {
            $response['message'] = '';
            $response['status_filex_state_wise'] = false;
        }
        if ($file_ex_invoice != "") {
            $response['message'] = 'success';
            $response['status_filex_without_invoice'] = true;
        } else {
            $response['message'] = '';
            $response['status_filex_without_invoice'] = false;
        }
        echo json_encode($response);
    }

}

?>
