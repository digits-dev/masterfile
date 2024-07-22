<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\City;
	use App\State;
	use App\Country;
	use App\Statuses;
	use App\Customer;
	use App\CustomerApproval;
	use App\ApprovalWorkflowSetting;
	use App\Channel;
	use App\OnlineBranch;
	use App\BeaStagingLocation;
	use Excel;
	use Carbon\Carbon;
	use PHPExcel_Style_Border;
	use PHPExcel_Style_Fill;

	class AdminCustomerModuleController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "cutomer_name";
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
			$this->table = "customer";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			//$this->col[] = ["label"=>"Action Type","name"=>"action_type"];
			//$this->col[] = ["label"=>"Approval Status Id","name"=>"approval_status_id"];
			

			$this->col[] = ["label"=>"Customer Code","name"=>"customer_code"];
			$this->col[] = ["label"=>"Cutomer/Location Name","name"=>"cutomer_name"];
			$this->col[] = ["label"=>"Concept","name"=>"concept"];
			$this->col[] = ["label"=>"Customer Type","name"=>"channel_id","join"=>"channels,channel_description"];
			$this->col[] = ["label"=>"Trade Name","name"=>"trade_name", "visible"=>false];
			$this->col[] = ["label"=>"Mall","name"=>"mall", "visible"=>false];
			$this->col[] = ["label"=>"Branch","name"=>"branch", "visible"=>false];
			$this->col[] = ["label"=>"Bill To","name"=>"bill_to"];
			
			$this->col[] = ["label"=>"Bea Staging Location","name"=>"bea_staging_location_id", "visible"=>false ,"join"=>"bea_staging_location,bea_location_description"];
			$this->col[] = ["label"=>"Channel","name"=>"channel_code_id" , "visible"=>false];
			
			$this->col[] = ["label"=>"Tax Country","name"=>"tax_country_id", "visible"=>false ,"join"=>"countries,country_name"];
			$this->col[] = ["label"=>"Building#/Building Name","name"=>"building_no", "visible"=>false];
			$this->col[] = ["label"=>"Lot & Blk#/Street Name","name"=>"lot_blk_no_streetname", "visible"=>false];
			$this->col[] = ["label"=>"Barangay","name"=>"barangay", "visible"=>false];
			$this->col[] = ["label"=>"City/Province","name"=>"city_id", "visible"=>false ,"join"=>"cities,city_name"];
			$this->col[] = ["label"=>"State/Region","name"=>"state_id", "visible"=>false ,"join"=>"states,state_name"];
			$this->col[] = ["label"=>"Area Code/Zip Code","name"=>"area_code_zip_code", "visible"=>false];
			$this->col[] = ["label"=>"Country","name"=>"country_id", "visible"=>false ,"join"=>"countries,country_name"];
			$this->col[] = ["label"=>"Ship To Address","name"=>"ship_to_address"];
			$this->col[] = ["label"=>"Contact Last Name","name"=>"contact_person_ln", "visible"=>false];
			$this->col[] = ["label"=>"Contact First Name","name"=>"contact_person_fn", "visible"=>false];
			$this->col[] = ["label"=>"TIN#","name"=>"tin_no"];
			$this->col[] = ["label"=>"Contact Person","name"=>"contact_person"];
			$this->col[] = ["label"=>"Designation","name"=>"contact_designation_id", "visible"=>false ,"join"=>"designation,designation_description"];
			$this->col[] = ["label"=>"Department","name"=>"contact_department_id", "visible"=>false ,"join"=>"department,department_name"];
			$this->col[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1", "visible"=>false];
			$this->col[] = ["label"=>"Area Code 1","name"=>"area_code_1", "visible"=>false];
			$this->col[] = ["label"=>"Number 1","name"=>"number_1", "visible"=>false];
			$this->col[] = ["label"=>"Landline#","name"=>"contact_landline_no", "visible"=>false];
			$this->col[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2", "visible"=>false];
			$this->col[] = ["label"=>"Area Code 2","name"=>"area_code_2", "visible"=>false];
			$this->col[] = ["label"=>"Number 2","name"=>"number_2", "visible"=>false];
			$this->col[] = ["label"=>"Mobile#","name"=>"mobile_number", "visible"=>false];
			$this->col[] = ["label"=>"Email Address","name"=>"email_address", "visible"=>false];
			$this->col[] = ["label"=>"Bank Details","name"=>"bank_details", "visible"=>false];
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
			$this->col[] = ["label"=>"Currency","name"=>"currency_id","join"=>"currencies,currency_code", "visible"=>false];
			$this->col[] = ["label"=>"Credit Limit","name"=>"credit_limit", "visible"=>false];
			$this->col[] = ["label"=>"Payment Terms","name"=>"payment_terms_id","join"=>"payment_terms,payment_terms_description"];
			$this->col[] = ["label"=>"Beach Pricelist","name"=>"bea_pricelist_id", "join"=>"bea_pricelist,bea_pricelist_description"];
			$this->col[] = ["label"=>"Payment Mode","name"=>"payment_mode_id","join"=>"payment_mode,payment_mode_description" , "visible"=>false];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"statuses,status_description"];
			$this->col[] = ["label"=>"Open Date","name"=>"open_date"];
			$this->col[] = ["label"=>"Close Date","name"=>"close_date"];
			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Updated Date","name"=>"updated_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			//,'placeholder'=>'Trade Name','help'=>'Put N/A if not applicable'
			$this->form[] = ["label"=>"Trade Name","name"=>"trade_name","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Trade Name'];
			$this->form[] = ["label"=>"Mall","name"=>"mall","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Mall','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Branch","name"=>"branch","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Branch','help'=>'Put N/A if not applicable'];			
			$this->form[] = ["label"=>"Customer Type","name"=>"channel_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"channels,channel_description","datatable_where"=>"status!='INACTIVE'"];			
			//$this->form[] = ["label"=>"Branch","name"=>"branch_onl","type"=>"select","width"=>"col-sm-6","datatable"=>"online_branch,onl_branch_code","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Channel","name"=>"channel_code_id","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Channel','readonly'=>true];
			$this->form[] = ["label"=>"Concept","name"=>"concept","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Concept','readonly'=>true];
			$this->form[] = ["label"=>"Customer/Location Name","name"=>"cutomer_name","type"=>"text","validation"=>"required|min:1|max:255|unique:customer",'width'=>'col-sm-6','placeholder'=>'Customer/Location Name','readonly'=>true];
			$this->form[] = ["label"=>"Length","name"=>"length","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Length','readonly'=>true];
			$this->form[] = ["label"=>"Bill To (Company Name)","name"=>"bill_to","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bill To','help'=>'Put N/A if not applicable'];
			//$this->form[] = ["label"=>"Bea Staging Location","name"=>"bea_staging_location_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"bea_staging_location,bea_location_description","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"TIN#","name"=>"tin_no","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'TIN#','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Tax Country","name"=>"tax_country_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"countries,country_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Building#/Building Name","name"=>"building_no","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Building#/Building Name','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Lot & Blk#/Street Name","name"=>"lot_blk_no_streetname","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Lot & Blk#/Street Name','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Barangay","name"=>"barangay","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Barangay','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"City/Province","name"=>"city_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"cities,city_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"State/Region","name"=>"state_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"states,state_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Area Code/Zip Code","name"=>"area_code_zip_code","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Area Code/Zip Code','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Country","name"=>"country_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"countries,country_name","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Ship To Address","name"=>"ship_to_address","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Ship To Address','readonly'=>true];
			
			$this->form[] = ["label"=>"Owner Name","name"=>"owner_name","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Owner Name','help'=>'Put N/A if not applicable'];
			
			$this->form[] = ["label"=>"Contact Last Name","name"=>"contact_person_ln","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact Last Name','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Contact First Name","name"=>"contact_person_fn","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact First Name','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Contact Person","name"=>"contact_person","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact Person','readonly'=>true];
			//$this->form[] = ["label"=>"Designation","name"=>"contact_designation_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"designation,designation_description","datatable_where"=>"status!='INACTIVE'"];
			//$this->form[] = ["label"=>"Department","name"=>"contact_department_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"department,department_name","datatable_where"=>"status!='INACTIVE'"];
			//$this->form[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'International Country Code 1'];
			//$this->form[] = ["label"=>"Area Code 1","name"=>"area_code_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Area Code 1'];
			//$this->form[] = ["label"=>"Number 1","name"=>"number_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Number 1'];
			$this->form[] = ["label"=>"Landline#","name"=>"contact_landline_no","type"=>"text","validation"=>"required|min:1",'width'=>'col-sm-6','placeholder'=>'Landline#','help'=>'Put N/A if not applicable'];
			//$this->form[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'International Country Code 1'];
			//$this->form[] = ["label"=>"Area Code 2","name"=>"area_code_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Area Code 1'];
			//$this->form[] = ["label"=>"Number 2","name"=>"number_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Number 1'];
			$this->form[] = ["label"=>"Mobile#","name"=>"mobile_number","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Mobile#','help'=>'Put N/A if not applicable'];
			$this->form[] = ["label"=>"Email Address","name"=>"email_address","type"=>"text",'validation'=>'required','width'=>'col-sm-6','help'=>'Put N/A if not applicable','placeholder'=>'Email Address'];
			//|email|unique:supplier,email_address,'.CRUDBooster::getCurrentId()
			//$this->form[] = ["label"=>"Bank Details","name"=>"bank_details","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Details'];
			//$this->form[] = ["label"=>"Beneficiary Name","name"=>"beneficiary_name","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Beneficiary Name'];
			//$this->form[] = ["label"=>"Account Number","name"=>"account_number","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Account Number'];
			//$this->form[] = ["label"=>"Beneficiary Address","name"=>"beneficiary_address","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Beneficiary Address'];
			//$this->form[] = ["label"=>"Bank Beneficiary","name"=>"bank_beneficiary","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Beneficiary'];
			//$this->form[] = ["label"=>"Bank Address","name"=>"bank_address","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Address'];
			//$this->form[] = ["label"=>"Bank Code","name"=>"bank_code","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Code'];
			//$this->form[] = ["label"=>"SWIFT Code","name"=>"switf_code","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'SWIFT Code'];
			//$this->form[] = ["label"=>"BIC","name"=>"bic","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'BIC'];
			//$this->form[] = ["label"=>"IBAN","name"=>"iban","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'IBAN'];
			//$this->form[] = ["label"=>"ABA","name"=>"aba","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'ABA'];
			//$this->form[] = ["label"=>"Currency","name"=>"currency_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"currencies,currency_code","datatable_where"=>"status!='INACTIVE'"];
			//$this->form[] = ["label"=>"Credit Limit","name"=>"credit_limit","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Credit Limit'];
			$this->form[] = ["label"=>"Payment Terms","name"=>"payment_terms_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"payment_terms,payment_terms_description","datatable_where"=>"status!='INACTIVE'"];
			
			//if(CRUDBooster::myPrivilegeName() == "Requestor"){
			//if(CRUDBooster::myPrivilegeName() != "Requestor"){
				$this->form[] = ["label"=>"Beach Pricelist","name"=>"bea_pricelist_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"bea_pricelist,bea_pricelist_description","datatable_where"=>"status!='INACTIVE'",'readonly'=>true];
			//}
			//}
			//$this->form[] = ["label"=>"Payment Mode","name"=>"payment_mode_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"payment_mode,payment_mode_description","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ['label'=>'Open Date','name'=>'open_date',"validation"=>"required",'type'=>'date','width'=>'col-sm-6'];
			
			if(CRUDBooster::getCurrentMethod() == 'getEdit' || CRUDBooster::getCurrentMethod() == 'postEditSave'){

				$this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select','validation'=>'required','width'=>'col-sm-6',"datatable"=>"statuses,status_description"];
				
				$this->form[] = ['label'=>'Close Date','name'=>'close_date',"validation"=>"",'type'=>'date','width'=>'col-sm-6'];
				
				$this->form[] = ['label'=>'Reason','name'=>'reason',"validation"=>"",'type'=>'text','width'=>'col-sm-6'];
			}
			if(CRUDBooster::getCurrentMethod() == 'getDetail'){
				$this->form[] = ['label'=>'Status','name'=>'status_id','type'=>'select','validation'=>'required','width'=>'col-sm-6',"datatable"=>"statuses,status_description"];
				$this->form[] = ["label"=>"Created By","name"=>"created_by",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ["label"=>"Created Date","name"=>"created_at"];
				$this->form[] = ["label"=>"Updated By","name"=>"updated_by",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ["label"=>"Updated Date","name"=>"updated_at"];
				//$this->form[] = ["label"=>"Approved By","name"=>"approved_by_2",'type'=>'select',"datatable"=>"cms_users,name"];
				//$this->form[] = ["label"=>"Approved Date","name"=>"approved_at_2"];
			}
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Action Type","name"=>"action_type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Approval Status Id","name"=>"approval_status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|min:1|max:255","datatable"=>"approval_status,id"];
			//$this->form[] = ["label"=>"Customer Code","name"=>"customer_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Channel Id","name"=>"channel_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"channel,id"];
			//$this->form[] = ["label"=>"Note","name"=>"note","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
			//$this->form[] = ["label"=>"Cutomer Name","name"=>"cutomer_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Concat Mall Branch","name"=>"concat_mall_branch","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Trade Name","name"=>"trade_name","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
			//$this->form[] = ["label"=>"Mall","name"=>"mall","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Branch","name"=>"branch","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Bill To","name"=>"bill_to","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tin No","name"=>"tin_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Tax Country Id","name"=>"tax_country_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"tax_country,id"];
			//$this->form[] = ["label"=>"Ship To Address","name"=>"ship_to_address","type"=>"textarea","required"=>TRUE,"validation"=>"required|string|min:5|max:5000"];
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
			//$this->form[] = ["label"=>"Account Person","name"=>"account_person","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Person Ln","name"=>"account_person_ln","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Person Fn","name"=>"account_person_fn","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Account Designation Id","name"=>"account_designation_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"account_designation,id"];
			//$this->form[] = ["label"=>"Account Department Id","name"=>"account_department_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"account_department,id"];
			//$this->form[] = ["label"=>"Landline No","name"=>"landline_no","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Area Code 1","name"=>"area_code_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Number 1","name"=>"number_1","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Mobile Number","name"=>"mobile_number","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Area Code 2","name"=>"area_code_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Number 2","name"=>"number_2","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Email Address","name"=>"email_address","type"=>"email","required"=>TRUE,"validation"=>"required|min:1|max:255|email|unique:customer","placeholder"=>"Please enter a valid email address"];
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
			//$this->form[] = ["label"=>"Payment Mode Id","name"=>"payment_mode_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"payment_mode,id"];
			//$this->form[] = ["label"=>"Bea Pricelist","name"=>"bea_pricelist","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Pos Name","name"=>"pos_name","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
				"icon"=>"fa fa-download","url"=>CRUDBooster::mainpath('GetExtractCustomerAndLocation').'?'.urldecode(http_build_query(@$_GET))];
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
	        $this->load_js[] = asset("js/customer_master.js");
	        
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
			$query->where(function($sub_query){
				
				//$data_status 		= Statuses::where('status_description', 'ACTIVE')->value('id');
				$create_item_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state');
				$update_item_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state');

				//$sub_query->where('customer.approval_status_id', 	$create_item_status)->where('customer.status_id', 	$data_status);
				//$sub_query->orWhere('customer.approval_status_id',	$update_item_status)->where('customer.status_id', 	$data_status);
				$sub_query->where('customer.approval_status_id', 	$create_item_status);
				$sub_query->orWhere('customer.approval_status_id',	$update_item_status);
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
			if($column_index == 12){
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
			//dd($postdata["cutomer_name"]);
			//$data_status =	 	Statuses::where('status_description', 'ACTIVE')->value('id');

			/*if($postdata["channel_id"] == 8){
				 $postdata["branch"]	= 	OnlineBranch::where('id', $postdata["branch_onl"])->value('onl_branch_code');
			}else{
				$postdata["branch"]	= $postdata["branch"];
			}*/

			$code = 0;
	
			$code = DB::table('code_counters')->where('id', 1)->value('customer_code');
			$code1 = str_pad($code, 4, '0', STR_PAD_LEFT);	
			$cus_code = "CUS-".$code1;
			//update counter
			$cnt = $code + 1;

			$postdata["customer_code"]				= $cus_code;
			$postdata["created_by"]					= CRUDBooster::myId();
			$postdata["status_id"]					= Statuses::where('status_description', 'ACTIVE')->value('id');
			$postdata["action_type"]				="Create";
			$postdata["encoder_privilege_id"]		= CRUDBooster::myPrivilegeId();
			//$postdata['approval_status_id']			= ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state');
            $postdata['approval_status_id']			= 1;
            $postdata['created_at']	                = date('Y-m-d H:i:s');
			DB::table('code_counters')->where('id', 1)->update(['customer_code' => $cnt]);

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
			$item_data = Customer::where('id',$id)->get()->toArray();	
			CustomerApproval::insert($item_data);

			$customer_data = Customer::where('id',$id)->first();	

			if(CRUDBooster::myPrivilegeName() == "Requestor"){
				
					$for_approval = CustomerApproval::where('id',$id)->first();
					$approvers = ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Create')
					->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->get();

					foreach ($approvers as $approvers_list){

						$approver_privilege_for =	DB::table('cms_privileges')->where('id',$approvers_list->encoder_privilege_id)->first();
						$approver_privilege =		DB::table('cms_privileges')->where('id',$approvers_list->approver_privilege_id)->first();	

						if($for_approval->encoder_privilege_id == $approver_privilege_for->id){
							$send_to =	DB::table('cms_users')->where('id_cms_privileges',$approver_privilege->id)->get();
							foreach ($send_to as $send_now){


									//$config['content'] =  CRUDBooster::myName(). " has created Customer with Customer/Location Name ".$for_approval->cutomer_name." at Customer Module!";
								
								$config['content'] =  CRUDBooster::myName(). " has created Customer and Location with Customer Code ".$customer_data->customer_code." at Customer Module!";

								$config['to'] = CRUDBooster::adminPath('customer_module/edit/'.$for_approval->id);
								$config['id_cms_users'] = [$send_now->id];
								CRUDBooster::sendNotification($config);	
							}

						}
					}
			}


		    $data = ['cutomer_name'=>$customer_data->cutomer_name,'date'=>date('Y-m-d')]; 
		    
		  //  CRUDBooster::sendEmail(['to'=>'rickyalnin201995@gmail.com','data'=>$data,'template'=>'customer_and_location','attachments'=>$files]);
		    
		    CRUDBooster::sendEmail(['to'=>'bpg@digits.ph','data'=>$data,'template'=>'customer_and_location','attachments'=>$files]);
		    
		   
		   
			CRUDBooster::redirect(CRUDBooster::mainpath(),"Customer and Location with Customer Code ".$customer_data->customer_code." has been created successfully.","info");
			//CRUDBooster::redirect(CRUDBooster::mainpath(),"Customer has been created and pending for approval.","info");
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
	        
	        $email_update = Customer::where('id',$id)->first();
			
			///dd(CRUDBooster::getCurrentModule()->id);
	        //Your code here
			//$postdata["action_type"]=		"Update";
			//$postdata["updated_by"]=		CRUDBooster::myId();
			//$postdata["encoder_privilege_id"]		= CRUDBooster::myPrivilegeId();
			//$postdata["approval_status_id"]=	ApprovalWorkflowSetting::where('workflow_number', 2)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('next_state');
			
			/*
			CustomerApproval::where('id',$id)->update([

				'trade_name'	=>   $postdata["trade_name"],
				'mall'	=>   $postdata["mall"],
				'channel_id'	=>  $postdata["channel_id"],
				'branch'	=>  $postdata["branch"],
				'branch_onl'	=>  $postdata["branch_onl"],
				'bill_to'	=>  $postdata["bill_to"],
				'bea_pricelist_id'	=>  $postdata["bea_pricelist_id"],
				'bea_staging_location_id'	=>  $postdata["bea_staging_location_id"],
				'channel_code_id'	=>  $postdata["channel_code_id"],
				'concept'	=>  $postdata["concept"],
				'cutomer_name'	=>  $postdata["cutomer_name"],
				'tin_no'	=>  $postdata["tin_no"],
				'tax_country_id'	=>  $postdata["tax_country_id"],
				'building_no'	=>  $postdata["building_no"],
				'lot_blk_no_streetname'	=>  $postdata["lot_blk_no_streetname"],
				'barangay'	=> $postdata["barangay"],
				'city_id'	=>  $postdata["city_id"],
				'state_id'	=>  $postdata["state_id"],
				'area_code_zip_code'	=>  $postdata["area_code_zip_code"],
				'country_id'	=>  $postdata["country_id"],
				'ship_to_address'	=>  $postdata["ship_to_address"],
				'contact_person_ln'	=>  $postdata["contact_person_ln"],
				'contact_person_fn'	=>  $postdata["contact_person_fn"],
				'contact_person'	=>  $postdata["contact_person"],
				'contact_designation_id'	=>  $postdata["contact_designation_id"],
				'contact_department_id'	=>  $postdata["contact_department_id"],
				'international_country_code_1'	=>  $postdata["international_country_code_1"],
				'area_code_1'	=>  $postdata["area_code_1"],
				'number_1'	=>  $postdata["number_1"],
				'contact_landline_no'	=>  $postdata["contact_landline_no"],
				'international_country_code_2'	=>  $postdata["international_country_code_2"],
				'area_code_2'	=>  $postdata["area_code_2"],
				'number_2'	=>  $postdata["number_2"],
				'mobile_number'	=>  $postdata["mobile_number"],
				'email_address'	=>  $postdata["email_address"],
				'bank_details'	=>  $postdata["bank_details"],
				'beneficiary_name'	=> $postdata["beneficiary_name"],
				'account_number'	=>  $postdata["account_number"],
				'beneficiary_address'	=>  $postdata["beneficiary_address"],
				'bank_beneficiary'	=>  $postdata["bank_beneficiary"],
				'bank_address'	=>  $postdata["bank_address"],
				'bank_code'	=>  $postdata["bank_code"],
				'switf_code'	=>  $postdata["switf_code"],
				'bic'	=>  $postdata["bic"],
				'iban'	=>  $postdata["iban"],
				'aba'	=>  $postdata["aba"],
				'currency_id'	=>  $postdata["currency_id"],
				'credit_limit'	=>  $postdata["credit_limit"],
				'payment_terms_id'	=>  $postdata["payment_terms_id"],
				'payment_mode_id'	=>  $postdata["payment_mode_id"],
				'status_id'	=>  $postdata["status_id"],
				'action_type'	=>  "Update",
				'updated_by'	=>  CRUDBooster::myId(),
				'updated_at'	=>  date('Y-m-d H:i:s'),
				
				'encoder_privilege_id'	=>  CRUDBooster::myPrivilegeId(),
				'approval_status_id'	=>  ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state')
			
			]);

			
			unset($postdata);
			unset($this->arr);
			*/


			//$this->arr["encoder_privilege_id"] = CRUDBooster::myPrivilegeId();

			//$this->arr["updated_by"] = CRUDBooster::myId();
			//$this->arr["action_type"] = "Update";

			$postdata["updated_by"]				= CRUDBooster::myId();
			$postdata['updated_at']	            = date('Y-m-d H:i:s');
			$postdata["encoder_privilege_id"]	= CRUDBooster::myPrivilegeId();
			$postdata["action_type"]			= "Update";
			
			if($postdata["reason"] == null || $postdata["reason"] == "" || $postdata["reason"] == " "){
			    	$postdata["reason"]	= "";
			}

			CustomerApproval::where('id',$id)->update([
				'trade_name'	=>   $postdata["trade_name"],
				'mall'	=>   $postdata["mall"],
				'branch'	=>  $postdata["branch"],
				'channel_id'	=>  $postdata["channel_id"],
				//'branch_onl'	=>  $postdata["branch_onl"],
				'channel_code_id'	=>  $postdata["channel_code_id"],
				'concept'	=>  $postdata["concept"],
				'cutomer_name'	=>  $postdata["cutomer_name"],
				'length'	=>  $postdata["length"],
				'bill_to'	=>  $postdata["bill_to"],
				'tin_no'	=>  $postdata["tin_no"],
				'tax_country_id'	=>  $postdata["tax_country_id"],
				'building_no'	=>  $postdata["building_no"],
				'lot_blk_no_streetname'	=>  $postdata["lot_blk_no_streetname"],
				'barangay'	=>  $postdata["barangay"],
				'city_id'	=> $postdata["city_id"],
				'state_id'	=>  $postdata["state_id"],
				'area_code_zip_code'	=>  $postdata["area_code_zip_code"],
				'country_id'	=>  $postdata["country_id"],
				'ship_to_address'	=>  $postdata["ship_to_address"],
				'contact_person_ln'	=>  $postdata["contact_person_ln"],
				'contact_person_fn'	=>  $postdata["contact_person_fn"],
				'contact_person'	=>  $postdata["contact_person"],
				'contact_landline_no'	=>  $postdata["contact_landline_no"],
				'mobile_number'	=>  $postdata["mobile_number"],
				'email_address'	=>  $postdata["email_address"],
				'payment_terms_id'	=>  $postdata["payment_terms_id"],
				'bea_pricelist_id'	=>  $postdata["bea_pricelist_id"],
				'status_id'	=>  $postdata["status_id"],
				'close_date'	=>  $postdata["close_date"],
				'reason'	=>  $postdata["reason"],
				'owner_name'	=>  $postdata["owner_name"],
				'action_type'	=>  "Update",
				'updated_by'	=>  CRUDBooster::myId(),
				'updated_at'	=>  date('Y-m-d H:i:s'),
				'encoder_privilege_id'	=>  CRUDBooster::myPrivilegeId(),
			//	'approval_status_id'	=>  ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state')
			    'approval_status_id'	=>  10
			]);
			
			
		    $data = ['cutomer_name'=>$email_update->cutomer_name,'cutomer_name_new'=>$postdata["cutomer_name"],'date'=>date('Y-m-d')]; 

		  //  CRUDBooster::sendEmail(['to'=>'rickyalnin201995@gmail.com','data'=>$data,'template'=>'customer_and_location_update','attachments'=>$files]);
		    
		    CRUDBooster::sendEmail(['to'=>'bpg@digits.ph','data'=>$data,'template'=>'customer_and_location_update','attachments'=>$files]);

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

			//$customer_infos = Customer::where('id',$id)->first();
			
			/*CustomerApproval::where('id',$customer_infos->id)->update([

				'channel_id'	=>   $customer_infos->channel_id,
				'channel_code_id'	=>   $customer_infos->channel_code_id,
				'note'	=>  $customer_infos->note,
				'cutomer_name'	=>  $customer_infos->cutomer_name,
				'concept'	=>  $customer_infos->concept,
				'trade_name'	=>  $customer_infos->trade_name,
				'mall'	=>  $customer_infos->mall,
				'branch'	=>  $customer_infos->branch,
				'branch_onl'	=>  $customer_infos->branch_onl,
				'bill_to'	=>  $customer_infos->bill_to,
				'tin_no'	=>  $customer_infos->tin_no,
				'tax_country_id'	=>  $customer_infos->tax_country_id,
				'ship_to_address'	=>  $customer_infos->ship_to_address,
				'building_no'	=>  $customer_infos->building_no,
				'lot_blk_no_streetname'	=>  $customer_infos->lot_blk_no_streetname,
				'barangay'	=>  $customer_infos->barangay,
				'city_id'	=>  $customer_infos->city_id,
				'state_id'	=>  $customer_infos->state_id,
				'area_code_zip_code'	=>  $customer_infos->area_code_zip_code,
				'country_id'	=>  $customer_infos->country_id,
				'contact_person'	=>  $customer_infos->contact_person,
				'contact_person_ln'	=>  $customer_infos->contact_person_ln,
				'contact_person_fn'	=>  $customer_infos->contact_person_fn,
				'contact_designation_id'	=>  $customer_infos->contact_designation_id,
				'contact_department_id'	=>  $customer_infos->contact_department_id,
				'account_person'	=>  $customer_infos->account_person,
				'account_person_ln'	=>  $customer_infos->account_person_ln,
				'account_person_fn'	=>  $customer_infos->account_person_fn,
				'account_designation_id'	=>  $customer_infos->account_designation_id,
				'account_department_id'	=>  $customer_infos->account_department_id,
				'contact_landline_no'	=>  $customer_infos->contact_landline_no,
				'international_country_code_1'	=>  $customer_infos->international_country_code_1,
				'area_code_1'	=>  $customer_infos->area_code_1,
				'number_1'	=>  $customer_infos->number_1,
				'mobile_number'	=>  $customer_infos->mobile_number,
				'international_country_code_2'	=>  $customer_infos->international_country_code_2,
				'area_code_2'	=>  $customer_infos->area_code_2,
				'number_2'	=>  $customer_infos->number_2,
				'email_address'	=>  $customer_infos->email_address,
				'bank_details'	=>  $customer_infos->bank_details,
				'beneficiary_name'	=>  $customer_infos->beneficiary_name,
				'account_number'	=>  $customer_infos->account_number,
				'beneficiary_address'	=>  $customer_infos->beneficiary_address,
				'bank_beneficiary'	=>  $customer_infos->bank_beneficiary,
				'bank_address'	=>  $customer_infos->bank_address,
				'bank_code'	=>  $customer_infos->bank_code,
				'switf_code'	=>  $customer_infos->switf_code,
				'bic'	=>  $customer_infos->bic,
				'iban'	=>  $customer_infos->iban,
				'aba'	=>  $customer_infos->aba,
				'currency_id'	=>  $customer_infos->currency_id,
				'credit_limit'	=>  $customer_infos->credit_limit,
				'payment_terms_id'	=>  $customer_infos->payment_terms_id,
				'payment_mode_id'	=>  $customer_infos->payment_mode_id,
				'bea_pricelist_id'	=>  $customer_infos->bea_pricelist_id,
				'bea_staging_location_id'	=>  $customer_infos->bea_staging_location_id,
				'pos_name_id'	=>  $customer_infos->pos_name_id,
				'ref'	=>  $customer_infos->ref,
				'status_id'	=>  $customer_infos->status_id,

				'action_type'	=>  $customer_infos->action_type,
				'updated_by'	=>  $customer_infos->updated_by,
				'updated_at'	=>  $customer_infos->updated_at,
				'approval_status_id'	=>  $customer_infos->approval_status_id
			]);*/
			/*
			$for_approval = CustomerApproval::where('id',$id)->first();
			$approvers = ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Update')
			->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->get();

			foreach ($approvers as $approvers_list){

				$approver_privilege_for =	DB::table('cms_privileges')->where('id',$approvers_list->encoder_privilege_id)->first();
				$approver_privilege =		DB::table('cms_privileges')->where('id',$approvers_list->approver_privilege_id)->first();	

				if($for_approval->encoder_privilege_id == $approver_privilege_for->id){
					$send_to =	DB::table('cms_users')->where('id_cms_privileges',$approver_privilege->id)->get();
					foreach ($send_to as $send_now){


							$config['content'] =  CRUDBooster::myName(). " has edited Customer with Customer/Location Name ".$for_approval->cutomer_name." at Customer Module!";
						

						$config['to'] = CRUDBooster::adminPath('customer_approval/detail/'.$for_approval->id);
						$config['id_cms_users'] = [$send_now->id];
						CRUDBooster::sendNotification($config);	
					}

				}
				
			}*/


			//CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Customer(s) has been edited successfully !","success");
			
			$customer_data = Customer::where('id',$id)->first();	

			CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Customer and Location with Customer Code ".$customer_data->customer_code." has been edited successfully.","info");
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

		public function getCustomerType($id){

	    	$country_value = Channel::where('id', $id)->value('channel_code');
			return $country_value;
			
		}

		public function getBranchOnline($id){

	    	$branch_value = OnlineBranch::where('id', $id)->value('onl_branch_code');
			return $branch_value;
			
		}

		public function getBeaStaging($id){

	    	$bea_value = BeaStagingLocation::where('id', $id)->value('bea_location_description');
			return $bea_value;
			
		}

		/*
		public function getEdit($id) {

		    $module_id = DB::table('cms_moduls')->where('controller','AdminCustomerModuleController')->value('id');
		    
			$item_info = Customer::find($id);

			//$create_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			//$supplier_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			$created_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');

			//dd($created_update_status);
			if ($item_info->action_type == "Update") {
				CRUDBooster::redirect(CRUDBooster::mainpath(""),"You're not allowed to edit pending items for approval.","warning");
			}
			
			return parent::getEdit($id);
		}
		*/

		public function GetExtractCustomerAndLocation() {
		    
		    ini_set('max_execution_time', 0);
	        ini_set('memory_limit',"-1");

            $filename = 'Customer And Location - ' . date("d M Y - h.i.sa");
			$sheetname = 'Customer And Location'.date("d-M-Y");
           
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

					$orderData = DB::table('customer')
					->leftjoin('channels', 'customer.channel_id','=', 'channels.id')
					//->leftjoin('customer', 'customer.customer','=', 'customer.id')
					->leftjoin('countries', 'customer.tax_country_id','=', 'countries.id')
					->leftjoin('cities', 'customer.city_id','=', 'cities.id')		
					->leftjoin('states', 'customer.state_id','=', 'states.id')				
					->leftjoin('countries as country', 'customer.country_id','=', 'country.id')																	
					->leftjoin('payment_terms', 'customer.payment_terms_id','=', 'payment_terms.id')
					->leftjoin('bea_pricelist', 'customer.bea_pricelist_id','=', 'bea_pricelist.id')
					->leftjoin('statuses', 'customer.status_id','=', 'statuses.id')	
					->leftjoin('cms_users as created', 'customer.created_by','=', 'created.id')
					->leftjoin('cms_users as updated', 'customer.updated_by','=', 'updated.id')
					->select( 	'customer.*', 
								'channels.channel_description', 
								'countries.country_name', 
								'cities.city_name',	
								'states.state_name',
								'country.country_name as name_country',
								'payment_terms.payment_terms_description',	
								'bea_pricelist.bea_pricelist_description',	
								'statuses.status_description',
								'created.name as by_created',
								'updated.name as by_updated'
							//)->where('customer.status_id', 1);
							)->where('customer.deleted_at', null);
	
						if(\Request::get('filter_column')) {

								$filter_column = \Request::get('filter_column');

								$orderData->where(function($w) use ($filter_column,$fc){
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

					$ordeDataLines = $orderData->orderBy('customer.id','asc')->get();
					$blank_field = '';
					$store_inv = '';
					$counter=0;
					$final_count = count((array)$ordeDataLines) + 1;
					foreach ($ordeDataLines as $orderRow) {
					    $counter++;
			
						$orderItems[] = array(
							//is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
							//is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
							$orderRow->customer_code, 	
							$orderRow->status_description,
							$orderRow->cutomer_name, 	
							//$orderRow->length,				
							$orderRow->concept,					
							$orderRow->channel_description,				
							//$orderRow->channel_code_id,		
							$orderRow->trade_name,	
							$orderRow->mall,		            
							$orderRow->branch,      
							$orderRow->bill_to,    
							$orderRow->tin_no,		
							$orderRow->country_name,    
							$orderRow->ship_to_address,
							$orderRow->building_no,		
							$orderRow->lot_blk_no_streetname,	
							$orderRow->barangay,                  
							$orderRow->city_name,                   
							$orderRow->city_name,		
							$orderRow->area_code_zip_code,                      
							$orderRow->name_country, 
							$orderRow->owner_name, 
							$orderRow->contact_person,                           
							$orderRow->contact_person_ln, 
							$orderRow->contact_person_fn,  
				 			          
				 			$orderRow->contact_landline_no,                 
				 			$orderRow->mobile_number,            
				 			$orderRow->email_address,          
							$orderRow->payment_terms_description,
							$orderRow->bea_pricelist_description,
							
							$orderRow->open_date,
							$orderRow->close_date,
							$orderRow->reason,
							
				 			$orderRow->by_created,                
							$orderRow->created_at,
							$orderRow->by_updated,
							$orderRow->updated_at
						);
					}

					$headings = array(
						'Customer Code',
						'Status',                //bue   //additional code 20200121
						'Customer/Location Name',
						//'Length',
						'Concept',
						'Customer Type',
						//'Channel',
						'Trade Name',
						'Mall',
						'Branch',
						'Bill To (Company Name)',
						'TIN#',
						'Tax Country',
						'Ship To Address',         //red
						'Building#/Building Name',
						'Lot & Blk#/Street Name',
						'Barangay',    //yellow
						'City/Province',      //red
						'State/Region',         //red
						'Area Code/Zip Code',         //red
						'Country',//green
						'Owner Name',                 //green
						'Contact Person',                 //green
						'Contact Last Name',//green
						'Contact First Name',               //green
						
						'Landline#',      //blue
						'Mobile#',               //blue
						'Email Address',                 //bue
						'Payment Terms',              //blue  //additional code 20200121
                        'Beach Pricelist',                //bue   //additional code 20200121
                        
                        'Open Date',                //bue   //additional code 20200121
                        'Close Date',                //bue   //additional code 20200121
						'Reason ',                //bue   //additional code 20200121
						
						'Created By',       //additional code 20200207
						'Created Date',       //additional code 20200207
						'Updated By',           //blue  //additional code 20200205
						'Updated Date'
					);

					$sheet->fromArray($orderItems, null, 'A1', false, false);
					$sheet->prependRow(1, $headings);

                             
                    $sheet->getStyle('A1:AI1')->applyFromArray(array(
                        'fill' => array(
                            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '8DB4E2') //141,180,226->8DB4E2
                        )
                    ));
                    $sheet->cells('A1:AI1'.$final_count, function($cells) {
                    	$cells->setAlignment('left');
                    	
                    });
 
				});
			})->export('xlsx');
			
		}
	
	}