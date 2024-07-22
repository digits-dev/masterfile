<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\City;
	use App\State;
	use App\Country;
	use App\Statuses;
	use App\Supplier;
	use App\SupplierApproval;
	use App\ApprovalWorkflowSetting;
	use Excel;
	use Carbon\Carbon;
	use PHPExcel_Style_Border;
	use PHPExcel_Style_Fill;

	class AdminSupplierModuleController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "employee_name";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = false;
			$this->table = "supplier";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			//$this->col[] = ["label"=>"Action Type","name"=>"action_type"];
			//$this->col[] = ["label"=>"Approval Status","name"=>"approval_status_id"];
			$this->col[] = ["label"=>"Supplier Code","name"=>"supplier_code"];
			$this->col[] = ["label"=>"Supplier Name","name"=>"supplier_name"];
			$this->col[] = ["label"=>"Supplier Site/Branch","name"=>"supplier_site_branch"];
			$this->col[] = ["label"=>"Incoterms","name"=>"incoterms", "visible"=>false];
			$this->col[] = ["label"=>"TIN#","name"=>"tin_no", "visible"=>false];
			$this->col[] = ["label"=>"Tax Country","name"=>"tax_country_id", "visible"=>false ,"join"=>"countries,country_name"];
			$this->col[] = ["label"=>"Building#/Building Name","name"=>"building_no", "visible"=>false];
			$this->col[] = ["label"=>"Lot & Blk#/Street Name","name"=>"lot_blk_no_streetname", "visible"=>false];
			$this->col[] = ["label"=>"Barangay","name"=>"barangay", "visible"=>false];
			$this->col[] = ["label"=>"City/Province","name"=>"city_id", "visible"=>false ,"join"=>"cities,city_name"];
			$this->col[] = ["label"=>"State/Region","name"=>"state_id", "visible"=>false ,"join"=>"states,state_name"];
			$this->col[] = ["label"=>"Area Code/Zip Code","name"=>"area_code_zip_code", "visible"=>false];
			$this->col[] = ["label"=>"Country","name"=>"country_id", "visible"=>false ,"join"=>"countries,country_name"];
			$this->col[] = ["label"=>"Employee Name","name"=>"employee_name"];
			$this->col[] = ["label"=>"Address Line 1","name"=>"address_line1"];
			$this->col[] = ["label"=>"Contact Last Name","name"=>"contact_person_ln", "visible"=>false];
			$this->col[] = ["label"=>"Contact First Name","name"=>"contact_person_fn", "visible"=>false];
			//$this->col[] = ["label"=>"Contact Person","name"=>"contact_person"];
			$this->col[] = ["label"=>"Designation","name"=>"contact_designation_id", "visible"=>false ,"join"=>"designation,designation_description"];
			$this->col[] = ["label"=>"Department","name"=>"contact_department_id", "visible"=>false ,"join"=>"department,department_name"];
			//$this->col[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1", "visible"=>false];
			//$this->col[] = ["label"=>"Area Code 1","name"=>"area_code_1", "visible"=>false];
			//$this->col[] = ["label"=>"Number 1","name"=>"number_1", "visible"=>false];
			$this->col[] = ["label"=>"Landline#","name"=>"contact_landline_no", "visible"=>false];
			//$this->col[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2", "visible"=>false];
			//$this->col[] = ["label"=>"Area Code 2","name"=>"area_code_2", "visible"=>false];
			$this->col[] = ["label"=>"Number 2","name"=>"number_2", "visible"=>false];
			$this->col[] = ["label"=>"Mobile#","name"=>"mobile_number", "visible"=>false];
			$this->col[] = ["label"=>"Email Address","name"=>"email_address", "visible"=>false];
			$this->col[] = ["label"=>"Beneficiary Name","name"=>"beneficiary_name", "visible"=>false];
			$this->col[] = ["label"=>"Account Number","name"=>"account_number", "visible"=>false];
			$this->col[] = ["label"=>"Beneficiary Address","name"=>"beneficiary_address", "visible"=>false];
			$this->col[] = ["label"=>"Bank Beneficiary","name"=>"bank_beneficiary", "visible"=>false];
			$this->col[] = ["label"=>"Bank Address","name"=>"bank_address", "visible"=>false];
			$this->col[] = ["label"=>"Bank Code","name"=>"bank_code", "visible"=>false];
			$this->col[] = ["label"=>"SWIFT Code","name"=>"switf_code", "visible"=>false];
			$this->col[] = ["label"=>"BIC","name"=>"bic", "visible"=>false];
			$this->col[] = ["label"=>"IBAN","name"=>"iban", "visible"=>false];
			$this->col[] = ["label"=>"ABA","name"=>"aba", "visible"=>false];
			$this->col[] = ["label"=>"Currency","name"=>"currency_id","join"=>"currencies,currency_code"];
			$this->col[] = ["label"=>"Credit Limit","name"=>"credit_limit", "visible"=>false];
			$this->col[] = ["label"=>"Payment Terms","name"=>"payment_terms_id","join"=>"payment_terms,payment_terms_description"];
			$this->col[] = ["label"=>"Withholding Tax Code","name"=>"holding_tax_code", "visible"=>false];
			$this->col[] = ["label"=>"VAT","name"=>"vat_id","join"=>"tax_codes,tax_description"];
			$this->col[] = ["label"=>"Contract Start Date","name"=>"contract_start_date", "visible"=>false];
			$this->col[] = ["label"=>"Contract End Date","name"=>"contract_end_date", "visible"=>false];
			$this->col[] = ["label"=>"RMA Support","name"=>"rma_support", "visible"=>false];
			$this->col[] = ["label"=>"Marketing Support","name"=>"marketing_support", "visible"=>false];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"statuses,status_description"];
			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Updated Date","name"=>"updated_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			//,'help'=>'Put N/A if not applicable'
			$this->form[] = ["label"=>"Supplier Name","name"=>"supplier_name","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Supplier Name'];
			$this->form[] = ["label"=>"Supplier Site/Branch","name"=>"supplier_site_branch","type"=>"text","validation"=>"required|min:1|max:15",'width'=>'col-sm-6','placeholder'=>'Supplier Site/Branch'];
			$this->form[] = ["label"=>"Incoterms","name"=>"incoterms","type"=>"text","validation"=>"required|min:1|max:3",'width'=>'col-sm-6','placeholder'=>'Incoterms','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"TIN#","name"=>"tin_no","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'TIN#','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Tax Country","name"=>"tax_country_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"countries,country_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Building#/Building Name","name"=>"building_no","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Building#/Building Name'];
			$this->form[] = ["label"=>"Lot & Blk#/Street Name","name"=>"lot_blk_no_streetname","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Lot & Blk#/Street Name'];
			$this->form[] = ["label"=>"Barangay","name"=>"barangay","type"=>"text","validation"=>"|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Barangay'];
			$this->form[] = ["label"=>"City/Province","name"=>"city_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"cities,city_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"State/Region","name"=>"state_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"states,state_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Area Code/Zip Code","name"=>"area_code_zip_code","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Area Code/Zip Code'];
			$this->form[] = ["label"=>"Country","name"=>"country_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"countries,country_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Address Line 1","name"=>"address_line1","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Address Line 1','readonly'=>true];
			$this->form[] = ["label"=>"Contact Last Name","name"=>"contact_person_ln","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact Last Name'];
			$this->form[] = ["label"=>"Contact First Name","name"=>"contact_person_fn","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact First Name'];
			$this->form[] = ["label"=>"Contact Person","name"=>"contact_person","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact Person','readonly'=>true];
			$this->form[] = ["label"=>"Employee Name (Last Name, First Name)","name"=>"employee_name","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact Person','readonly'=>true];
			$this->form[] = ["label"=>"Designation","name"=>"contact_designation_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"designation,designation_description","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Department","name"=>"contact_department_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"department,department_name","datatable_where"=>"status!='INACTIVE'"];
			//$this->form[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'International Country Code 1'];
			//$this->form[] = ["label"=>"Area Code 1","name"=>"area_code_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Area Code 1'];
			//$this->form[] = ["label"=>"Number 1","name"=>"number_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Number 1'];
			$this->form[] = ["label"=>"Landline#","name"=>"contact_landline_no","type"=>"text","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Landline#'];
			//$this->form[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'International Country Code 1'];
			//$this->form[] = ["label"=>"Area Code 2","name"=>"area_code_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Area Code 1'];
			//$this->form[] = ["label"=>"Number 2","name"=>"number_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Number 1'];
			$this->form[] = ["label"=>"Mobile#","name"=>"mobile_number","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Mobile#'];
			$this->form[] = ["label"=>"Email Address","name"=>"email_address","type"=>"email",'validation'=>'email|unique:supplier,email_address,'.CRUDBooster::getCurrentId(),'width'=>'col-sm-6'];
			$this->form[] = ["label"=>"Beneficiary Name","name"=>"beneficiary_name","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Beneficiary Name'];
			$this->form[] = ["label"=>"Account Number","name"=>"account_number","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Account Number'];
			$this->form[] = ["label"=>"Beneficiary Address","name"=>"beneficiary_address","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Beneficiary Address'];
			$this->form[] = ["label"=>"Bank Beneficiary","name"=>"bank_beneficiary","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Beneficiary'];
			$this->form[] = ["label"=>"Bank Address","name"=>"bank_address","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Address'];
			$this->form[] = ["label"=>"Bank Code","name"=>"bank_code","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Code'];
			$this->form[] = ["label"=>"SWIFT Code","name"=>"switf_code","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'SWIFT Code'];
			$this->form[] = ["label"=>"BIC","name"=>"bic","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'BIC'];
			$this->form[] = ["label"=>"IBAN","name"=>"iban","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'IBAN'];
			$this->form[] = ["label"=>"ABA","name"=>"aba","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'ABA'];
			$this->form[] = ["label"=>"Currency","name"=>"currency_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"currencies,currency_code","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Credit Limit","name"=>"credit_limit","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Credit Limit'];
			$this->form[] = ["label"=>"Payment Terms","name"=>"payment_terms_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"payment_terms,payment_terms_description","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Withholding Tax Code","name"=>"holding_tax_code","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Withholding Tax Code'];
			$this->form[] = ["label"=>"VAT","name"=>"vat_id","type"=>"select2","validation"=>"","width"=>"col-sm-6","datatable"=>"tax_codes,tax_description","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ['label'=>'Contract Start Date','name'=>'contract_start_date','type'=>'date','width'=>'col-sm-6'];
			$this->form[] = ['label'=>'Contract End Date','name'=>'contract_end_date','type'=>'date','width'=>'col-sm-6'];
			$this->form[] = ["label"=>"RMA Support","name"=>"rma_support","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'RMA Support'];
			$this->form[] = ["label"=>"Marketing Support","name"=>"marketing_support","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'MARKETING Support'];
			if(CRUDBooster::getCurrentMethod() == 'getEdit' || CRUDBooster::getCurrentMethod() == 'postEditSave'){

				$this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select','validation'=>'required','width'=>'col-sm-6',"datatable"=>"statuses,status_description"];
				
			}
			
			if(CRUDBooster::getCurrentMethod() == 'getDetail'){
				$this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select','validation'=>'required','width'=>'col-sm-6',"datatable"=>"statuses,status_description"];
				$this->form[] = ["label"=>"Created By","name"=>"created_by",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ["label"=>"Created Date","name"=>"created_at"];
				$this->form[] = ["label"=>"Updated By","name"=>"updated_by",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ["label"=>"Updated Date","name"=>"updated_at"];
				$this->form[] = ["label"=>"Approved By","name"=>"approved_by_2",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ["label"=>"Approved Date","name"=>"approved_at_2"];
			}
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Action Type","name"=>"action_type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Approval Status Id","name"=>"approval_status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"approval_status,id"];
			//$this->form[] = ["label"=>"Supplier Code","name"=>"supplier_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Channel Id","name"=>"channel_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"channel,id"];
			//$this->form[] = ["label"=>"Employee Name","name"=>"employee_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Supplier Name","name"=>"supplier_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Supplier Site Branch","name"=>"supplier_site_branch","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Incoterms","name"=>"incoterms","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tin No","name"=>"tin_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tax Country Id","name"=>"tax_country_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"tax_country,id"];
			//$this->form[] = ["label"=>"Address Line1","name"=>"address_line1","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Building No","name"=>"building_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Lot Blk No Streetname","name"=>"lot_blk_no_streetname","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Barangay","name"=>"barangay","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"City Id","name"=>"city_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"city,id"];
			//$this->form[] = ["label"=>"State Id","name"=>"state_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"state,id"];
			//$this->form[] = ["label"=>"Area Code Zip Code","name"=>"area_code_zip_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Country Id","name"=>"country_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"country,id"];
			//$this->form[] = ["label"=>"Contact Person","name"=>"contact_person","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact Person Ln","name"=>"contact_person_ln","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact Person Fn","name"=>"contact_person_fn","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Contact Designation Id","name"=>"contact_designation_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"contact_designation,id"];
			//$this->form[] = ["label"=>"Contact Department Id","name"=>"contact_department_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"contact_department,id"];
			//$this->form[] = ["label"=>"Contact Landline No","name"=>"contact_landline_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Area Code 1","name"=>"area_code_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Number 1","name"=>"number_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Mobile Number","name"=>"mobile_number","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Area Code 2","name"=>"area_code_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Number 2","name"=>"number_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Email Address","name"=>"email_address","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:supplier","placeholder"=>"Please enter a valid email address"];
			//$this->form[] = ["label"=>"Beneficiary Name","name"=>"beneficiary_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Number","name"=>"account_number","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Beneficiary Address","name"=>"beneficiary_address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Bank Beneficiary","name"=>"bank_beneficiary","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Bank Address","name"=>"bank_address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Bank Code","name"=>"bank_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Switf Code","name"=>"switf_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Bic","name"=>"bic","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Iban","name"=>"iban","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Aba","name"=>"aba","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Currency Id","name"=>"currency_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"currency,id"];
			//$this->form[] = ["label"=>"Credit Limit","name"=>"credit_limit","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Payment Terms Id","name"=>"payment_terms_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"payment_terms,id"];
			//$this->form[] = ["label"=>"Holding Tax Code","name"=>"holding_tax_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Vat Id","name"=>"vat_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"vat,id"];
			//$this->form[] = ["label"=>"Contract Start Date","name"=>"contract_start_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Contract End Date","name"=>"contract_end_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Rma Support","name"=>"rma_support","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Marketing Support","name"=>"marketing_support","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Ref","name"=>"ref","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Status Id","name"=>"status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"status,id"];
			//$this->form[] = ["label"=>"Status As Date","name"=>"status_as_date","type"=>"date","required"=>TRUE,"validation"=>"required|date"];
			//$this->form[] = ["label"=>"Approved By 1","name"=>"approved_by_1","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Approved At 1","name"=>"approved_at_1","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Disapproved At 1","name"=>"disapproved_at_1","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Approved By 2","name"=>"approved_by_2","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Approved At 2","name"=>"approved_at_2","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Disapproved At 2","name"=>"disapproved_at_2","type"=>"datetime","required"=>TRUE,"validation"=>"required|date_format:Y-m-d H:i:s"];
			//$this->form[] = ["label"=>"Created By","name"=>"created_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Updated By","name"=>"updated_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			# OLD END FORM

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
			if(CRUDBooster::getCurrentMethod() == 'getIndex' ){

				$this->index_button[] = ["title"=>"Export",
				"label"=>"Export",
				"icon"=>"fa fa-download","url"=>CRUDBooster::mainpath('GetExtractSupplier').'?'.urldecode(http_build_query(@$_GET))];
			}


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = NULL;


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        $this->load_js[] = asset("js/supplier_master.js");
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = NULL;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
		}
	


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
			$query->where(function($sub_query){
				
				$data_status 		= Statuses::where('status_description', 'ACTIVE')->value('id');
				$create_item_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state');
				$update_item_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state');

				$sub_query->where('supplier.approval_status_id', 	$create_item_status);
				$sub_query->orWhere('supplier.approval_status_id',	$update_item_status);

			}); 
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
			if($column_index == 10){
				switch ($column_value){
					case "INACTIVE":
						$column_value = '<span stye="display: block;" class="label label-danger">INACTIVE</span><br>';
						break;
					default:
						$column_value = '<span stye="display: block;" class="label label-info">ACTIVE</span><br>';
						break;
				}

			}
	    }
	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {  

			//Your code here		
			$data_status 							=Statuses::where('status_description', 'ACTIVE')->value('id');
			
			$code = 0;
	
			$code = DB::table('code_counters')->where('id', 1)->value('supplier_code');
			$code1 = str_pad($code, 4, '0', STR_PAD_LEFT);	
			$sup_code = "SUP-".$code1;
			//update counter
			$cnt = $code + 1;


			$postdata["supplier_code"]				= $sup_code;
			$postdata["created_by"]					=CRUDBooster::myId();
			$postdata["status_id"]					=$data_status;
			$postdata["action_type"]				="Create";
			$postdata["encoder_privilege_id"]		=CRUDBooster::myPrivilegeId();
			$postdata['approval_status_id']			= ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state');

			DB::table('code_counters')->where('id', 1)->update(['supplier_code' => $cnt]);

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here
			$item_data = Supplier::where('id',$id)->get()->toArray();	
			SupplierApproval::insert($item_data);

			/*$for_approval = SupplierApproval::where('id',$id)->first();
			$approvers = ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Create')
			->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->get();

			foreach ($approvers as $approvers_list){

				$approver_privilege_for =	DB::table('cms_privileges')->where('id',$approvers_list->encoder_privilege_id)->first();
				$approver_privilege =		DB::table('cms_privileges')->where('id',$approvers_list->approver_privilege_id)->first();	

				if($for_approval->encoder_privilege_id == $approver_privilege_for->id){
					$send_to =	DB::table('cms_users')->where('id_cms_privileges',$approver_privilege->id)->get();
					foreach ($send_to as $send_now){

						if($for_approval->supplier_name != null){
							$config['content'] =  CRUDBooster::myName(). " has created Supplier with Supplier Code ".$for_approval->supplier_name." at Supplier Module!";
						}else{
							$config['content'] =  CRUDBooster::myName(). " has created Supplier with Contact Person ".$for_approval->contact_person." at Supplier Module!";
						}

						$config['to'] = CRUDBooster::adminPath('supplier_approval/edit/'.$for_approval->id);
						$config['id_cms_users'] = [$send_now->id];
						CRUDBooster::sendNotification($config);	
					}

				}
				
			}
			*/
			$supplier_data = Supplier::where('id',$id)->first();	

			CRUDBooster::redirect(CRUDBooster::mainpath(),"Supplier with Supplier Code ".$supplier_data->supplier_code." has been created successfully.","info");

			//CRUDBooster::redirect(CRUDBooster::mainpath(),"Supplier has been created and pending for approval.","info");
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {        
	        //Your code here
			//$postdata["action_type"]=			"Update";
			//$postdata["updated_by"]=			CRUDBooster::myId();
			//$postdata["encoder_privilege_id"]		= CRUDBooster::myPrivilegeId();
			//$postdata["approval_status_id"]= 	ApprovalWorkflowSetting::where('workflow_number', 2)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('next_state');			
			
			/*
			SupplierApproval::where('id', $id)->update([
				'supplier_name'	=>  $postdata["supplier_name"],
				'supplier_site_branch'	=>  $postdata["supplier_site_branch"],
				'incoterms'	=>  $postdata["incoterms"],
				'tin_no'	=>  $postdata["tin_no"],
				'tax_country_id'	=> $postdata["tax_country_id"],
				'building_no'	=> $postdata["building_no"],
				'lot_blk_no_streetname'	=>  $postdata["lot_blk_no_streetname"],
				'barangay'	=>  $postdata["barangay"],
				'city_id'	=>  $postdata["city_id"],
				'state_id'	=>  $postdata["state_id"],
				'area_code_zip_code'	=>  $postdata["area_code_zip_code"],
				'country_id'	=>  $postdata["country_id"],
				'address_line1'	=>  $postdata["address_line1"],
				'contact_person_ln'	=>  $postdata["contact_person_ln"],
				'contact_person_fn'	=>  $postdata["contact_person_fn"],
				'contact_person'	=>  $postdata["contact_person"],
				'contact_designation_id'	=> $postdata["contact_designation_id"],
				'contact_department_id'	=>  $postdata["contact_department_id"],
				'international_country_code_1'	=>  $postdata["international_country_code_1"],
				'area_code_1'	=>  $postdata["area_code_1"],
				'number_1'	=>  $postdata["number_1"],
				'contact_landline_no'	=>  $postdata["contact_landline_no"],
				'international_country_code_2'	=>  $postdata["international_country_code_2"],
				'area_code_2'	=>  $postdata["area_code_2"],
				'number_2'	=> $postdata["number_2"],
				'mobile_number'	=> $postdata["mobile_number"],
				'email_address'	=>  $postdata["email_address"],
				'beneficiary_name'	=>  $postdata["beneficiary_name"],
				'account_number'	=>  $postdata["account_number"],
				'beneficiary_address'	=> $postdata["beneficiary_address"],
				'bank_beneficiary'	=>  $postdata["bank_beneficiary"],
				'bank_address'	=>  $postdata["bank_address"],
				'bank_code'	=> $postdata["bank_code"],
				'switf_code'	=>  $postdata["switf_code"],
				'bic'	=>  $postdata["bic"],
				'iban'	=>  $postdata["iban"],
				'aba'	=>  $postdata["aba"],
				'currency_id'	=>  $postdata["currency_id"],
				'credit_limit'	=>  $postdata["credit_limit"],
				'payment_terms_id'	=>  $postdata["payment_terms_id"],
				'holding_tax_code'	=>  $postdata["holding_tax_code"],
				'vat_id'	=> 	$postdata["vat_id"],
				'contract_start_date'	=> $postdata["contract_start_date"],
				'contract_end_date'	=>  $postdata["contract_end_date"],
				'rma_support'	=>  $postdata["rma_support"],
				'marketing_support'	=>  $postdata["marketing_support"],
				'status_id'	=>  $postdata["status_id"],
				'action_type'	=>  "Update",
				'updated_by'	=>  CRUDBooster::myId(),
				'updated_at'	=>  date('Y-m-d H:i:s'),
				'encoder_privilege_id'	=>  CRUDBooster::myPrivilegeId(),
				'approval_status_id'	=>  ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state')
			]);

			

			unset($postdata);
			unset($this->arr);

			$this->arr["encoder_privilege_id"] = CRUDBooster::myPrivilegeId();
			$this->arr["updated_by"] = CRUDBooster::myId();
			$this->arr["action_type"] = "Update"; */


			$postdata["updated_by"]				= CRUDBooster::myId();
			$postdata["encoder_privilege_id"]	= CRUDBooster::myPrivilegeId();
			$postdata["action_type"]			= "Update";



			SupplierApproval::where('id',$id)->update([
				'supplier_name'	=>   $postdata["supplier_name"],
				'supplier_site_branch'	=>   $postdata["supplier_site_branch"],
				'incoterms'	=>  $postdata["incoterms"],
				'tin_no'	=>  $postdata["tin_no"],
				'tax_country_id'	=>  $postdata["tax_country_id"],
				'building_no'	=>  $postdata["building_no"],
				'lot_blk_no_streetname'	=>  $postdata["lot_blk_no_streetname"],
				'barangay'	=>  $postdata["barangay"],
				'city_id'	=>  $postdata["city_id"],
				'state_id'	=>  $postdata["state_id"],
				'area_code_zip_code'	=>  $postdata["area_code_zip_code"],
				'country_id'	=>  $postdata["country_id"],
				'address_line1'	=>  $postdata["address_line1"],
				'contact_person_ln'	=>  $postdata["contact_person_ln"],
				'contact_person_fn'	=>  $postdata["contact_person_fn"],
				'contact_person'	=> $postdata["contact_person"],
				'employee_name'	=>  $postdata["employee_name"],
				'contact_designation_id'	=>  $postdata["contact_designation_id"],
				'contact_department_id'	=>  $postdata["contact_department_id"],
				'contact_landline_no'	=>  $postdata["contact_landline_no"],
				'mobile_number'	=>  $postdata["mobile_number"],
				'email_address'	=>  $postdata["email_address"],
				'beneficiary_name'	=>  $postdata["beneficiary_name"],
				'account_number'	=>  $postdata["account_number"],
				'beneficiary_address'	=>  $postdata["beneficiary_address"],
				'bank_beneficiary'	=>  $postdata["bank_beneficiary"],
				'bank_address'	=>  $postdata["bank_address"],
				'switf_code'	=>  $postdata["switf_code"],
				'bic'	=>  $postdata["bic"],
				'iban'	=>  $postdata["iban"],
				'aba'	=>  $postdata["aba"],
				'currency_id'	=>  $postdata["currency_id"],
				'credit_limit'	=>  $postdata["credit_limit"],
				'payment_terms_id'	=>  $postdata["payment_terms_id"],
				'holding_tax_code'	=>  $postdata["holding_tax_code"],
				'vat_id'	=>  $postdata["vat_id"],
				'contract_start_date'	=>  $postdata["contract_start_date"],
				'contract_end_date'	=>  $postdata["contract_end_date"],
				'rma_support'	=>  $postdata["rma_support"],
				'marketing_support'	=>  $postdata["marketing_support"],

				'status_id'	=>  $postdata["status_id"],
				'action_type'	=>  "Update",
				'updated_by'	=>  CRUDBooster::myId(),
				'updated_at'	=>  date('Y-m-d H:i:s'),
				'encoder_privilege_id'	=>  CRUDBooster::myPrivilegeId(),
				'approval_status_id'	=>  ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state')
			
			]);
			
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 
			//$supplier_infos = Supplier::where('id',$id)->first();

			/*
			SupplierApproval::where('id',$supplier_infos->id)->update([
				'supplier_name'	=>  $supplier_infos->supplier_name,
				'supplier_site_branch'	=>  $supplier_infos->supplier_site_branch,
				'incoterms'	=>  $supplier_infos->incoterms,
				'tin_no'	=>  $supplier_infos->tin_no,
				'tax_country_id'	=>  $supplier_infos->tax_country_id,
				'building_no'	=>  $supplier_infos->building_no,
				'lot_blk_no_streetname'	=>  $supplier_infos->lot_blk_no_streetname,
				'barangay'	=>  $supplier_infos->barangay,
				'city_id'	=>  $supplier_infos->city_id,
				'state_id'	=>  $supplier_infos->state_id,
				'area_code_zip_code'	=>  $supplier_infos->area_code_zip_code,
				'country_id'	=>  $supplier_infos->country_id,
				'contact_person'	=>  $supplier_infos->contact_person,
				'contact_person_ln'	=>  $supplier_infos->contact_person_ln,
				'contact_person_fn'	=>  $supplier_infos->contact_person_fn,
				'contact_designation_id'	=>  $supplier_infos->contact_designation_id,
				'contact_department_id'	=>  $supplier_infos->contact_department_id,
				'contact_landline_no'	=>  $supplier_infos->contact_landline_no,
				'international_country_code_1'	=>  $supplier_infos->international_country_code_1,
				'area_code_1'	=>  $supplier_infos->area_code_1,
				'number_1'	=>  $supplier_infos->number_1,
				'mobile_number'	=>  $supplier_infos->mobile_number,
				'international_country_code_2'	=>  $supplier_infos->international_country_code_2,
				'area_code_2'	=>  $supplier_infos->area_code_2,
				'number_2'	=>  $supplier_infos->number_2,
				'email_address'	=>  $supplier_infos->email_address,
				'beneficiary_name'	=>  $supplier_infos->beneficiary_name,
				'account_number'	=>  $supplier_infos->account_number,
				'beneficiary_address'	=>  $supplier_infos->beneficiary_address,
				'bank_beneficiary'	=>  $supplier_infos->bank_beneficiary,
				'bank_address'	=>  $supplier_infos->bank_address,
				'bank_code'	=>  $supplier_infos->bank_code,
				'switf_code'	=>  $supplier_infos->switf_code,
				'bic'	=>  $supplier_infos->bic,
				'iban'	=>  $supplier_infos->iban,
				'aba'	=>  $supplier_infos->aba,
				'currency_id'	=>  $supplier_infos->currency_id,
				'credit_limit'	=>  $supplier_infos->credit_limit,
				'payment_terms_id'	=>  $supplier_infos->payment_terms_id,
				'holding_tax_code'	=>  $supplier_infos->holding_tax_code,
				'vat_id'	=>  $supplier_infos->vat_id,
				'contract_start_date'	=>  $supplier_infos->contract_start_date,
				'contract_end_date'	=>  $supplier_infos->contract_end_date,
				'rma_support'	=>  $supplier_infos->rma_support,
				'marketing_support'	=>  $supplier_infos->marketing_support,
				'status_id'	=>  $supplier_infos->status_id,
				'status_as_date'	=>  $supplier_infos->status_as_date,
				'action_type'	=>  $supplier_infos->action_type,
				'updated_by'	=>  $supplier_infos->updated_by,
				'updated_at'	=>  $supplier_infos->updated_at,
				'approval_status_id'	=>  $supplier_infos->approval_status_id
			]);

			*/

			/*$for_approval = SupplierApproval::where('id',$id)->first();
			$approvers = ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Update')
			->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->get();

			foreach ($approvers as $approvers_list){

				$approver_privilege_for =	DB::table('cms_privileges')->where('id',$approvers_list->encoder_privilege_id)->first();
				$approver_privilege =		DB::table('cms_privileges')->where('id',$approvers_list->approver_privilege_id)->first();	

				if($for_approval->encoder_privilege_id == $approver_privilege_for->id){
					$send_to =	DB::table('cms_users')->where('id_cms_privileges',$approver_privilege->id)->get();
					foreach ($send_to as $send_now){

						if($for_approval->supplier_name != null){
							$config['content'] =  CRUDBooster::myName(). " has edited Supplier with Supplier Code ".$for_approval->supplier_name." at Supplier Module!";
						}else{
							$config['content'] =  CRUDBooster::myName(). " has edited Supplier with Contact Person ".$for_approval->contact_person." at Supplier Module!";
						}

						$config['to'] = CRUDBooster::adminPath('supplier_approval/edit/'.$for_approval->id);
						$config['id_cms_users'] = [$send_now->id];
						CRUDBooster::sendNotification($config);	
					}

				}
				
			}*/

			$supplier_data = Supplier::where('id',$id)->first();

			CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Supplier with Supplier Code ".$supplier_data->supplier_code." has been edited successfully.","info");
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }

		public function getCity($id){

	    	$city_value = City::where('id', $id)->value('city_name');
			return $city_value;
			
		}
		
		public function getState($id){

	    	$state_value = State::where('id', $id)->value('state_name');
			return $state_value;
			
	    }

		public function getCountry($id){

	    	$country_value = Country::where('id', $id)->value('country_name');
			return $country_value;
			
		}

		/*
		public function getEdit($id) {

			$module_id = DB::table('cms_moduls')->where('controller','AdminSupplierModuleController')->value('id');
		    
			$item_info = Supplier::find($id);

			//$create_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			//$supplier_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			$created_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');

			//dd($created_update_status);
			if ($item_info->action_type == "Update") {
				CRUDBooster::redirect(CRUDBooster::mainpath(""),"You're not allowed to edit pending items for approval.","warning");
			}
			
			return parent::getEdit($id);
		} */


		public function GetExtractSupplier() {

            $filename = 'Supplier - ' . date("d M Y - h.i.sa");
			$sheetname = 'Supplier'.date("d-M-Y");
            //ini_set('memory_limit', '512M');
			Excel::create($filename, function ($excel) {
				$excel->sheet('orders', function ($sheet) {	
					// Set auto size for sheet
					
					$sheet->setAutoSize(true);
					$sheet->setColumnFormat(array(
					    'J' => '@',		//for upc code
					    'AI' => '0.00',
					    'AJ' => '0.00',
					    'AK' => '0.00',
					));

					$orderData = DB::table('supplier')
					->leftjoin('channels', 'supplier.channel_id','=', 'channels.id')
					//->leftjoin('customer', 'customer.customer','=', 'customer.id')
					->leftjoin('countries', 'supplier.tax_country_id','=', 'countries.id')
					->leftjoin('cities', 'supplier.city_id','=', 'cities.id')		
					->leftjoin('states', 'supplier.state_id','=', 'states.id')				
					->leftjoin('countries as country', 'supplier.country_id','=', 'country.id')																	
					->leftjoin('payment_terms', 'supplier.payment_terms_id','=', 'payment_terms.id')
					
					->leftjoin('designation', 'supplier.contact_designation_id','=', 'designation.id')
					->leftjoin('department', 'supplier.contact_department_id','=', 'department.id')

					->leftjoin('currencies', 'supplier.currency_id','=', 'currencies.id')
					->leftjoin('tax_codes', 'supplier.vat_id','=', 'tax_codes.id')
					
					//->leftjoin('bea_pricelist', 'supplier.bea_pricelist_id','=', 'bea_pricelist.id')
					->leftjoin('statuses', 'supplier.status_id','=', 'statuses.id')	
					->leftjoin('cms_users as created', 'supplier.created_by','=', 'created.id')
					->leftjoin('cms_users as updated', 'supplier.updated_by','=', 'updated.id')
					->select( 	'supplier.*', 
								'channels.channel_description', 
								'countries.country_name', 
								'cities.city_name',	
								'states.state_name',
								'country.country_name as name_country',
								'payment_terms.payment_terms_description',	
								'designation.designation_description',
								'department.department_name',
								'currencies.currency_code',
								'tax_codes.tax_description',
								//'bea_pricelist.bea_pricelist_description',	
								'statuses.status_description',
								'created.name as by_created',
								'updated.name as by_updated'
							)->where('supplier.status_id', 1);
	
						if(\Request::get('filter_column')) {

								$filter_column = \Request::get('filter_column');

								$orderData->where(function($w) use ($filter_column,$fc) {
									foreach($filter_column as $key=>$fc) {

										$value = @$fc['value'];
										$type  = @$fc['type'];

										if($type == 'empty') {
											$w->whereNull($key)->orWhere($key,'');
											continue;
										}

										if($value=='' || $type=='') continue;

										if($type == 'between') continue;

										switch($type) {
											default:
												if($key && $type && $value) $w->where($key,$type,$value);
											break;
											case 'like':
											case 'not like':
												$value = '%'.$value.'%';
												if($key && $type && $value) $w->where($key,$type,$value);
											break;
											case 'in':
											case 'not in':
												if($value) {
													$value = explode(',',$value);
													if($key && $value) $w->whereIn($key,$value);
												}
											break;
										}
									}
								});

								foreach($filter_column as $key=>$fc) {
									$value = @$fc['value'];
									$type  = @$fc['type'];
									$sorting = @$fc['sorting'];

									if($sorting!='') {
										if($key) {
											$orderData->orderby($key,$sorting);
											$filter_is_orderby = true;
										}
									}

									if ($type=='between') {
										if($key && $value) $orderData->whereBetween($key,$value);
									}

									else {
										continue;
									}
								}
						}

					$ordeDataLines = $orderData->orderBy('supplier.id','asc')->get();
					$blank_field = '';
					$store_inv = '';
					$counter=0;
					$final_count = count((array)$ordeDataLines) + 1;
					foreach ($ordeDataLines as $orderRow) {
					    $counter++;
			
						$orderItems[] = array(
							//is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
							//is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
							
							$orderRow->supplier_code,
							$orderRow->supplier_name, 		
							$orderRow->supplier_site_branch, 	
							$orderRow->incoterms,				
							$orderRow->tin_no,					
							$orderRow->country_name,				
							$orderRow->building_no,		
							$orderRow->lot_blk_no_streetname,	
							$orderRow->barangay,		            
							$orderRow->city_name,      
							$orderRow->state_name,    
							$orderRow->area_code_zip_code,		
							$orderRow->name_country,			
							$orderRow->address_line1,		
							$orderRow->contact_person_ln,	
							$orderRow->contact_person_fn,                  
							$orderRow->contact_person,                   
							$orderRow->employee_name,		
							$orderRow->designation_description,                      
							$orderRow->department_name, 
							$orderRow->contact_landline_no,                      
							$orderRow->mobile_number, 
							$orderRow->email_address,  
				 			$orderRow->beneficiary_name,               
				 			$orderRow->account_number,                 
				 			$orderRow->beneficiary_address,            
				 			$orderRow->bank_beneficiary,          
							$orderRow->bank_address,
							$orderRow->bank_code,
							$orderRow->switf_code,
							$orderRow->bic,
							$orderRow->iban,
							$orderRow->iban,
							$orderRow->currency_code,
							$orderRow->credit_limit,
							$orderRow->payment_terms_description,
							$orderRow->holding_tax_code,
							$orderRow->tax_description,
							$orderRow->contract_start_date,
							$orderRow->contract_end_date,
							$orderRow->rma_support,
							$orderRow->marketing_support,

							$orderRow->status_description,
				 			$orderRow->by_created,                
							$orderRow->created_at,
							$orderRow->by_updated,
							$orderRow->updated_at
						);
					}

					$headings = array(
						'Supplier Code',
						'Supplier Name',
						'Supplier Site/Branch',
						'Incoterms',
						'TIN#',
						'Tax Country',
						'Building#/Building Name',
						'Lot & Blk#/Street Name',
						'Barangay',
						'City/Province',
						'State/Region',
						'Area Code/Zip Code',
						'Country',
						'Address Line 1',
						'Contact Last Name',    //yellow
						'Contact First Name',      //red
						'Contact Person',         //red
						'Employee Name (Last Name, First Name)',         //red
						'Designation',//green
						'Department',         //red
						'Landline#',//green
						'Mobile#',               //green
						'Email Address',                 //green
						'Beneficiary Name',      //blue
						'Account Number',               //blue
						'Beneficiary Address',                 //bue
						'Bank Beneficiary',              //blue  //additional code 20200121
                        'Bank Address',                //bue   //additional code 20200121
						'Bank Code',                //bue   //additional code 20200121
						'SWIFT Code',                //bue   //additional code 20200121
						'BIC',                //bue   //additional code 20200121
						'IBAN',                //bue   //additional code 20200121
						'ABA',                //bue   //additional code 20200121
						'Currency',                //bue   //additional code 20200121
						'Credit Limit',                //bue   //additional code 20200121
						'Payment Terms',                //bue   //additional code 20200121
						'Withholding Tax Code',                //bue   //additional code 20200121
						'VAT',                //bue   //additional code 20200121
						'Contract Start Date',                //bue   //additional code 20200121
						'Contract End Date',                //bue   //additional code 20200121
						'RMA Support',                //bue   //additional code 20200121
						'Marketing Support',                //bue   //additional code 20200121
						'Status',                //bue   //additional code 20200121
						'Created By',       //additional code 20200207
						'Created Date',       //additional code 20200207
						'Updated By',           //blue  //additional code 20200205
						'Updated Date'
					);

					$sheet->fromArray($orderItems, null, 'A1', false, false);
					$sheet->prependRow(1, $headings);

                             
                    $sheet->getStyle('A1:AU1')->applyFromArray(array(
                        'fill' => array(
                            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '8DB4E2') //141,180,226->8DB4E2
                        )
                    ));
                    $sheet->cells('A1:AH1'.$final_count, function($cells) {
                    	$cells->setAlignment('left');
                    	
                    });
 
				});
			})->export('xlsx');
			
		}
		
	}