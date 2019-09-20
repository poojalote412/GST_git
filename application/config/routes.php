<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'welcome';
$route['abc'] = 'welcome/aa1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

//customer
$route['Cust_dashboard'] = 'Gst_dashboard/index';
$route['Cfo_dashboard'] = 'Cfo_dashboard/index_customer';
$route['Sale_state_wise'] = 'Management_report/state_wise_report';
$route['Sale_taxable_nontaxable'] = 'Management_report/sale_taxable_nontaxable'; //sale_taxable_nontaxable and exempt route
$route['Sale_month_wise'] = 'Management_report/sale_month_wise';
$route['Account'] = 'Account_report/index_customer';
$route['TurnoverVsTaxability'] = 'Internal_acc_report/index';
$route['Tax_turnover'] = 'Internal_acc_report/tax_turnover';
$route['Invoice_comparison'] = 'Invoice_comp_report/index';
$route['Threeb_Vs_one'] = 'Threeb_vs_one/index';
$route['Threeb_vs_twoa'] = 'Threeb_vs_twoa/index';
$route['Sale_b2b_b2c'] = 'Management_report/Sale_b2b_b2c';
$route['GST_Logout'] = 'Gst_dashboard/index';
$route['not_in_2a'] = 'Invoice_comp_report/not_in_2a_index';
$route['not_in_record'] = 'Invoice_comp_report/not_in_record_index';
$route['partial_match'] = 'Invoice_comp_report/partial_match_index';
$route['eligible_ineligible_itc'] = 'Internal_acc_report/eligible_ineligible_itc_index';
$route['gst_payable_vs_cash'] = 'Internal_acc_report/gst_payable_vs_cash_index';


$route['Customer'] = 'Customer/index';
$route['test'] = 'Test/index';

//Routes for admin

$route['Admin_dashboard'] = 'Admin_dashboard/index';
$route['Cfo_dashboard_admin'] = 'Cfo_dashboard/index_admin';
$route['Customer'] = 'Customer_admin/index';
$route['add_customer'] = 'Customer_admin/add_customer';
$route['Customer_details'] = 'Customer_admin/index';
$route['Threeb_Vs_one_admin'] = 'Threeb_vs_one/index_admin';
$route['Threeb_vs_twoa_admin'] = 'Threeb_vs_twoa/index_admin';
$route['Sale_state_wise_admin'] = 'Management_report/state_wise_report_admin';
$route['Sale_taxable_nontaxable_admin'] = 'Management_report/sale_taxable_nontaxable_admin'; //sale_taxable_nontaxable and exempt route
$route['Sale_month_wise_admin'] = 'Management_report/sale_month_wise_admin';
$route['Sale_b2b_b2c_admin'] = 'Management_report/Sale_b2b_b2c_admin';
$route['Account_admin'] = 'Account_report/index_admin';
$route['TurnoverVsTaxability_admin'] = 'Internal_acc_report/index_admin';
$route['Tax_turnover_admin'] = 'Internal_acc_report/tax_turnover_admin';
$route['eligible_ineligible_itc_admin'] = 'Internal_acc_report/eligible_ineligible_itc_index_admin';
$route['gst_payable_vs_cash_admin'] = 'Internal_acc_report/gst_payable_vs_cash_index_admin';
$route['not_in_2a_admin'] = 'Invoice_comp_report/not_in_2a_index_admin';
$route['not_in_record_admin'] = 'Invoice_comp_report/not_in_record_index_admin';
$route['partial_match_admin'] = 'Invoice_comp_report/partial_match_index_admin';
$route['invoice_amendment'] = 'Invoice_comp_report/invoice_amendment_index';
$route['invoice_not_included_admin'] = 'Invoice_comp_report/invoice_not_included_index_admin';
$route['GST_Logout_admin'] = 'Gst_dashboard/index_admin';
$route['sale_export'] = 'Management_report/sale_exports_fun';
$route['sale_nil_zero_rated'] = 'Management_report/sale_nil_zero_rated_fun';
$route['sale_rate_wise'] = 'Management_report/sale_rate_wise_fun';
$route['enter_detail/(:any)/(:any)'] = 'report/enter_detail_fun/$1/$2';
$route['Generate_report/(:any)/(:any)'] = 'Report/index/$1/$2';
$route['Generate_report_with_page_num/(:any)/(:any)'] = 'Report/report_with_page_num/$1/$2';
$route['update_detail/(:any)/(:any)'] = 'Report/update_detail_fun/$1/$2';
$route['Word_to_database'] = 'Word_database/index_admin';
$route['generatepdf'] = "welcome/convertpdf";


//Routes for HQ admin 

$route['Hq_dashboard'] = 'Hq_dashboard/index';
$route['Cfo_dashboard_hq'] = 'Cfo_dashboard/index_hq';
$route['Customer_hq'] = 'Hq_customer/index';
$route['add_customer_hq'] = 'Hq_customer/add_customer';
$route['Customer_details_hq'] = 'Hq_customer/index';
//$route['Customer_details_hq'] = 'Customer_admin/index_hq';
$route['Threeb_Vs_one_hq'] = 'Threeb_vs_one/index_hq';
$route['Threeb_vs_twoa_hq'] = 'Threeb_vs_twoa/index_hq';
$route['Sale_state_wise_hq'] = 'Management_report/state_wise_report_hq';
$route['Sale_taxable_nontaxable_hq'] = 'Management_report/sale_taxable_nontaxable_hq'; //sale_taxable_nontaxable and exempt route
$route['Sale_month_wise_hq'] = 'Management_report/sale_month_wise_hq';
$route['Sale_b2b_b2c_hq'] = 'Management_report/Sale_b2b_b2c_hq';
$route['Account_hq'] = 'Account_report/index_hq';
$route['TurnoverVsTaxability_hq'] = 'Internal_acc_report/index_hq';
$route['Tax_turnover_hq'] = 'Internal_acc_report/tax_turnover_hq';
$route['eligible_ineligible_itc_hq'] = 'Internal_acc_report/eligible_ineligible_itc_index_hq';
$route['gst_payable_vs_cash_hq'] = 'Internal_acc_report/gst_payable_vs_cash_index_hq';
$route['not_in_2a_hq'] = 'Invoice_comp_report/not_in_2a_index_hq';
$route['not_in_record_hq'] = 'Invoice_comp_report/not_in_record_index_hq';
$route['partial_match_hq'] = 'Invoice_comp_report/partial_match_index_hq';
$route['invoice_amendment_hq'] = 'Invoice_comp_report/invoice_amendment_index_hq';
$route['invoice_not_included_hq'] = 'Invoice_comp_report/invoice_not_included_index_hq';
$route['GST_Logout_admin'] = 'Gst_dashboard/index_hq';
$route['sale_export'] = 'Management_report/sale_exports_fun';
$route['sale_nil_zero_rated'] = 'Management_report/sale_nil_zero_rated_fun';
$route['sale_rate_wise'] = 'Management_report/sale_rate_wise_fun';
$route['enter_detail/(:any)/(:any)'] = 'report/enter_detail_fun_hq/$1/$2';
$route['Generate_report/(:any)/(:any)'] = 'Report/index_hq/$1/$2';
$route['Generate_report_with_page_num/(:any)/(:any)'] = 'Report/report_with_page_num_hq/$1/$2';
$route['update_detail/(:any)/(:any)'] = 'Report/update_detail_fun_hq/$1/$2';
