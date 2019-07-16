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
$route['Cfo_dashboard'] = 'Cfo_dashboard/index';
$route['Sale_state_wise'] = 'Management_report/state_wise_report';
$route['Sale_taxable_nontaxable'] = 'Management_report/sale_taxable_nontaxable'; //sale_taxable_nontaxable and exempt route
$route['Sale_month_wise'] = 'Management_report/sale_month_wise';
$route['Account'] = 'Account_report/index';
$route['TurnoverVsTaxability'] = 'Internal_acc_report/index';
$route['Tax_turnover'] = 'Internal_acc_report/tax_turnover';
$route['Invoice_comparison'] = 'Invoice_comp_report/index';
$route['Threeb_Vs_one'] = 'Threeb_vs_one/index';
$route['Threeb_vs_twoa'] = 'Threeb_vs_twoa/index';
$route['Sale_b2b_b2c'] = 'Management_report/Sale_b2b_b2c';
$route['GST_Logout'] = 'Gst_dashboard/index';
$route['not_in_2a'] = 'Invoice_comp_report/not_in_2a_index';
$route['not_in_record'] = 'Invoice_comp_report/not_in_record_index';
//$route['Cust_login']='GST_Dashboard/employee_dashboard';

$route['Customer'] = 'Customer/index';
$route['test'] = 'Test/index';

//Routes for admin

$route['Admin_dashboard'] = 'Admin_dashboard/index';
$route['Cfo_dashboard_admin'] = 'Cfo_dashboard/index_admin';
$route['Customer'] = 'Customer_admin/index';
$route['add_customer']='Customer_admin/add_customer';
$route['Threeb_Vs_one_admin'] = 'Threeb_vs_one/index_admin';
$route['Threeb_vs_twoa_admin'] = 'Threeb_vs_twoa/index_admin';
$route['Sale_state_wise_admin'] = 'Management_report/state_wise_report_admin';
$route['Sale_taxable_nontaxable_admin'] = 'Management_report/sale_taxable_nontaxable_admin'; //sale_taxable_nontaxable and exempt route
$route['Sale_month_wise_admin'] = 'Management_report/sale_month_wise_admin';
$route['Sale_b2b_b2c_admin'] = 'Management_report/Sale_b2b_b2c_admin';
$route['Account_admin'] = 'Account_report/index_admin';
$route['TurnoverVsTaxability_admin'] = 'Internal_acc_report/index_admin';
$route['Tax_turnover_admin'] = 'Internal_acc_report/tax_turnover_admin';
$route['not_in_2a_admin'] = 'Invoice_comp_report/not_in_2a_index_admin';
$route['not_in_record_admin'] = 'Invoice_comp_report/not_in_record_index_admin';
$route['GST_Logout_admin'] = 'Gst_dashboard/index_admin';

