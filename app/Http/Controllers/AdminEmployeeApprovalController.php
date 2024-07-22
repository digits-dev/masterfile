<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\City;
	use App\State;
	use App\Country;
	use App\Statuses;
	use App\Employee;
	use App\EmployeeApproval;
	use App\ApprovalWorkflowSetting;
	use App\CustomerTypes;
	use App\Channel;

	class AdminEmployeeApprovalController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {
	    	# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->table 			   = "employee_approval";	        
			$this->title_field         = "customer_location_name";
			$this->limit               = 20;
			$this->orderby             = "id,desc";
			$this->show_numbering      = FALSE;
			$this->global_privilege    = FALSE;	        
			$this->button_table_action = TRUE;   
			$this->button_action_style = "button_icon";     
			$this->button_add          = false;
			$this->button_delete       = TRUE;
			$this->button_edit         = TRUE;
			$this->button_detail       = TRUE;
			$this->button_show         = TRUE;
			$this->button_filter       = TRUE;        
			$this->button_export       = TRUE;	        
			$this->button_import       = FALSE;
			$this->button_bulk_action  = TRUE;	
			# END CONFIGURATION DO NOT REMOVE THIS LINE						      

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = array();
			$this->col[] = ["label"=>"Action Type","name"=>"action_type"];
			$this->col[] = ["label"=>"Approval Status","name"=>"approval_status_id"];

			$this->col[] = ["label"=>"Employee Code","name"=>"employee_code"];

			$this->col[] = ["label"=>"Last Name","name"=>"contact_person_ln", "visible"=>false];
			$this->col[] = ["label"=>"First Name","name"=>"contact_person_fn", "visible"=>false];
			$this->col[] = ["label"=>"Contact Person","name"=>"contact_person", "visible"=>false];
			$this->col[] = ["label"=>"Bill To (Company Name)","name"=>"bill_to"];
			$this->col[] = ["label"=>"Customer/Location Name","name"=>"customer_location_name"];
			$this->col[] = ["label"=>"Designation","name"=>"contact_designation_id", "visible"=>false ,"join"=>"designation,designation_description"];
			$this->col[] = ["label"=>"Department","name"=>"contact_department_id", "visible"=>false ,"join"=>"department,department_name"];
			$this->col[] = ["label"=>"Customer Type","name"=>"customer_type", "visible"=>false ,"join"=>"channels,channel_description"];
			$this->col[] = ["label"=>"Channel Type","name"=>"channel_id", "channel_id"=>false ,"join"=>"channels,channel_code"];
			$this->col[] = ["label"=>"Building#/Building Name","name"=>"building_no", "visible"=>false];
			$this->col[] = ["label"=>"Lot & Blk#/Street Name","name"=>"lot_blk_no_streetname", "visible"=>false];
			$this->col[] = ["label"=>"Barangay","name"=>"barangay", "visible"=>false];
			$this->col[] = ["label"=>"City/Province","name"=>"city_id", "visible"=>false ,"join"=>"cities,city_name"];
			$this->col[] = ["label"=>"State/Region","name"=>"state_id", "visible"=>false ,"join"=>"states,state_name"];
			$this->col[] = ["label"=>"Area Code/Zip Code","name"=>"area_code_zip_code", "visible"=>false];
			$this->col[] = ["label"=>"Country","name"=>"country_id", "visible"=>false ,"join"=>"countries,country_name"];
			$this->col[] = ["label"=>"Ship To Address","name"=>"address_line1"];
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
			$this->col[] = ["label"=>"Currency","name"=>"currency_id","join"=>"currencies,currency_code"];
			$this->col[] = ["label"=>"Credit Limit","name"=>"credit_limit", "visible"=>false];
			$this->col[] = ["label"=>"Payment Terms","name"=>"payment_terms_id","join"=>"payment_terms,payment_terms_description"];
			$this->col[] = ["label"=>"Payment Mode","name"=>"payment_mode_id","join"=>"payment_mode,payment_mode_description"];
			$this->col[] = ["label"=>"Status","name"=>"status_id","join"=>"statuses,status_description"];
			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Updated Date","name"=>"updated_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE
			# START FORM DO NOT REMOVE THIS LINE
		$this->form = [];
		$this->form[] = ["label"=>"Last Name *","name"=>"contact_person_ln","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Last Name','help'=>'Put N/A if not applicable'];
		$this->form[] = ["label"=>"First Name *","name"=>"contact_person_fn","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'First Name','help'=>'Put N/A if not applicable'];
		$this->form[] = ["label"=>"Contact Person *","name"=>"contact_person","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Contact Person','readonly'=>true];
		$this->form[] = ["label"=>"Bill To (Company Name) *","name"=>"bill_to","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bill To (Company Name)','readonly'=>true];
		$this->form[] = ["label"=>"Customer/Location Name *","name"=>"customer_location_name","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Customer/Location Name','readonly'=>true];
		$this->form[] = ["label"=>"Designation","name"=>"contact_designation_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"designation,designation_description","datatable_where"=>"status!='INACTIVE'"];
		$this->form[] = ["label"=>"Department","name"=>"contact_department_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"department,department_name","datatable_where"=>"status!='INACTIVE'"];
		if(CRUDBooster::getCurrentMethod() == 'getDetail'){
			$this->form[] = ["label"=>"Customer Type","name"=>"customer_type","type"=>"select","validation"=>"required","width"=>"col-sm-6","datatable"=>"channels,channel_description","datatable_where"=>"status!='INACTIVE'"];
			$this->form[] = ["label"=>"Channel Type","name"=>"channel_id","type"=>"select","validation"=>"required","width"=>"col-sm-6","datatable"=>"channels,channel_code","datatable_where"=>"status!='INACTIVE'"];
		}
		$this->form[] = ["label"=>"Building#/Building Name","name"=>"building_no","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Building#/Building Name'];
		$this->form[] = ["label"=>"Lot & Blk#/Street Name","name"=>"lot_blk_no_streetname","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Lot & Blk#/Street Name'];
		$this->form[] = ["label"=>"Barangay","name"=>"barangay","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Barangay'];
		$this->form[] = ["label"=>"City/Province","name"=>"city_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"cities,city_name","datatable_where"=>"status!='INACTIVE'"];
		$this->form[] = ["label"=>"State/Region","name"=>"state_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"states,state_name","datatable_where"=>"status!='INACTIVE'"];
		$this->form[] = ["label"=>"Area Code/Zip Code","name"=>"area_code_zip_code","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Area Code/Zip Code'];
		$this->form[] = ["label"=>"Country","name"=>"country_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"countries,country_name","datatable_where"=>"status!='INACTIVE'"];
		$this->form[] = ["label"=>"Ship To Address","name"=>"address_line1","type"=>"text","validation"=>"required|min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Ship To Address','readonly'=>true];
		$this->form[] = ["label"=>"International Country Code 1","name"=>"international_country_code_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'International Country Code 1'];
		$this->form[] = ["label"=>"Area Code 1","name"=>"area_code_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Area Code 1'];
		$this->form[] = ["label"=>"Number 1","name"=>"number_1","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Number 1'];
		$this->form[] = ["label"=>"Landline#","name"=>"contact_landline_no","type"=>"text","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Landline#','readonly'=>true];
		$this->form[] = ["label"=>"International Country Code 2","name"=>"international_country_code_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'International Country Code 1'];
		$this->form[] = ["label"=>"Area Code 2","name"=>"area_code_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Area Code 1'];
		$this->form[] = ["label"=>"Number 2","name"=>"number_2","type"=>"number","validation"=>"min:1",'width'=>'col-sm-6','placeholder'=>'Number 1'];
		$this->form[] = ["label"=>"Mobile#","name"=>"mobile_number","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Mobile#','readonly'=>true];
		$this->form[] = ["label"=>"Email Address","name"=>"email_address","type"=>"email",'validation'=>'required|email|unique:supplier,email_address,'.CRUDBooster::getCurrentId(),'width'=>'col-sm-6'];
		$this->form[] = ["label"=>"Bank Details","name"=>"bank_details","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Bank Details'];
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
		$this->form[] = ["label"=>"Currency","name"=>"currency_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"currencies,currency_code","datatable_where"=>"status!='INACTIVE'"];
		$this->form[] = ["label"=>"Credit Limit","name"=>"credit_limit","type"=>"text","validation"=>"min:1|max:255",'width'=>'col-sm-6','placeholder'=>'Credit Limit'];
		$this->form[] = ["label"=>"Payment Terms","name"=>"payment_terms_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"payment_terms,payment_terms_description","datatable_where"=>"status!='INACTIVE'"];
		$this->form[] = ["label"=>"Payment Mode","name"=>"payment_mode_id","type"=>"select2","validation"=>"required","width"=>"col-sm-6","datatable"=>"payment_mode,payment_mode_description","datatable_where"=>"status!='INACTIVE'"];
		if(CRUDBooster::getCurrentMethod() == 'getDetail'){
			$this->form[] = ["label"=>"Created By","name"=>"created_by",'type'=>'select',"datatable"=>"cms_users,name"];
			$this->form[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->form[] = ["label"=>"Updated By","name"=>"updated_by",'type'=>'select',"datatable"=>"cms_users,name"];
			$this->form[] = ["label"=>"Updated Date","name"=>"updated_at"];
		}
			# END FORM DO NOT REMOVE THIS LINE     

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
	        if(CRUDBooster::isUpdate() && CRUDBooster::myPrivilegeName() == 'Admin' || CRUDBooster::myPrivilegeName() == 'Approver' || CRUDBooster::isSuperadmin())
	        {
	        	$this->button_selected[] = ['label'=>'APPROVE','icon'=>'fa fa-check','name'=>'APPROVE'];
				$this->button_selected[] = ['label'=>'DISAPPROVE','icon'=>'fa fa-times','name'=>'DISAPPROVE'];
				
			}
	                
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
	        $this->load_js[] = asset("js/employee_master_approval.js");
	        
	        
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
			$module_id = DB::table('cms_moduls')->where('controller','AdminEmployeeModuleController')->value('id');
			
			$employee_info = EmployeeApproval::whereIn('id',$id_selected)->get();
			
			if($button_name == 'APPROVE') {

				foreach ($employee_info as $employee_infos){

						if($employee_infos->action_type == "Create"){

							$code = 0;
	
							$code = DB::table('code_counters')->where('id', 1)->value('employee_code');
							$code1 = str_pad($code, 8, '0', STR_PAD_LEFT);	
							$emp_code = "EMP-".$code1;
							//update counter
							$cnt = $code + 1;

							$approver_checker = ApprovalWorkflowSetting::where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
												->where('approver_privilege_id',CRUDBooster::myPrivilegeId())
												->where('workflow_number', 2)
												->where('status','ACTIVE')->where('action_type', 'Create')->first();
											
							EmployeeApproval::where('id',$employee_infos->id)
									->update([
										'action_type' => "Create",
										'employee_code'	=>  $emp_code,
										'approval_status_id'	=>  $approver_checker->next_state,
										'approved_at_2' => date('Y-m-d H:i:s'), 
										'approved_by_2' => CRUDBooster::myId()
									]);
						
							Employee::where('id',$employee_infos->id)
									->update([
										'action_type' => "Create",
										'employee_code'	=>  $emp_code,
										'channel_id'	=>   $employee_infos->channel_id,
										'customer_type'	=>   $employee_infos->customer_type,
										'customer_location_name'	=>  $employee_infos->customer_location_name,
										'bill_to'	=>  $employee_infos->bill_to,
										'address_line1'	=>  $employee_infos->address_line1,
										'building_no'	=>  $employee_infos->building_no,
										'lot_blk_no_streetname'	=>  $employee_infos->lot_blk_no_streetname,
										'barangay'	=>  $employee_infos->barangay,
										'city_id'	=>  $employee_infos->city_id,
										'state_id'	=>  $employee_infos->state_id,
										'area_code_zip_code'	=>  $employee_infos->area_code_zip_code,
										'country_id'	=>  $employee_infos->country_id,
										'contact_person'	=>  $employee_infos->contact_person,
										'contact_person_ln'	=>  $employee_infos->contact_person_ln,
										'contact_person_fn'	=>  $employee_infos->contact_person_fn,
										'contact_designation_id'	=>  $employee_infos->contact_designation_id,
										'contact_department_id'	=>  $employee_infos->contact_department_id,
										'contact_landline_no'	=>  $employee_infos->contact_landline_no,
										'international_country_code_1'	=>  $employee_infos->international_country_code_1,
										'area_code_1'	=>  $employee_infos->area_code_1,
										'number_1'	=>  $employee_infos->number_1,
										'mobile_number'	=>  $employee_infos->mobile_number,
										'international_country_code_2'	=>  $employee_infos->international_country_code_2,
										'area_code_2'	=>  $employee_infos->area_code_2,
										'number_2'	=>  $employee_infos->number_2,
										'email_address'	=>  $employee_infos->email_address,
										'bank_details'	=>  $employee_infos->bank_details,
										'beneficiary_name'	=>  $employee_infos->beneficiary_name,
										'account_number'	=>  $employee_infos->account_number,
										'beneficiary_address'	=>  $employee_infos->beneficiary_address,
										'bank_beneficiary'	=>  $employee_infos->bank_beneficiary,
										'bank_address'	=>  $employee_infos->bank_address,
										'bank_code'	=>  $employee_infos->bank_code,
										'switf_code'	=>  $employee_infos->switf_code,
										'bic'	=>  $employee_infos->bic,
										'iban'	=>  $employee_infos->iban,
										'aba'	=>  $employee_infos->aba,
										'currency_id'	=>  $employee_infos->currency_id,
										'credit_limit'	=>  $employee_infos->credit_limit,
										'payment_terms_id'	=>  $employee_infos->payment_terms_id,
										'payment_mode_id'	=>  $employee_infos->payment_mode_id,
										'status_id'	=>  $employee_infos->status_id,
										'approved_by_1'	=>  $employee_infos->approved_by_1,
										'approved_at_1'	=>  $employee_infos->approved_at_1,
										'disapproved_at_1'	=>  $employee_infos->disapproved_at_1,
										'approval_status_id'	=>  $approver_checker->next_state,
										'approved_at_2' => date('Y-m-d H:i:s'), 
										'approved_by_2' => CRUDBooster::myId()
									]);

									DB::table('code_counters')->where('id', 1)->update(['employee_code' => $cnt]);

									$config['content'] = CRUDBooster::myName(). " has approved your Employee Created with Employee Code ".$emp_code." at Employee For Approval Module!";
									$config['to'] = CRUDBooster::adminPath('employee_module/detail/'.$employee_infos->id);
									$config['id_cms_users'] = [$employee_infos->created_by];		
									CRUDBooster::sendNotification($config);	
									$config['content'] = CRUDBooster::myName(). " has approved your Employee Edited with Employee Code ".$emp_code." at Employee For Approval Module!";
									$config['to'] = CRUDBooster::adminPath('employee_module/detail/'.$employee_infos->id);
									$config['id_cms_users'] = [$employee_infos->approved_by_1];	
									CRUDBooster::sendNotification($config);	
									CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Employee(s)  has been approved successfully !","success");
						}else{


							$approver_checker = ApprovalWorkflowSetting::where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
							->where('approver_privilege_id',CRUDBooster::myPrivilegeId())
							->where('workflow_number', 2)
							->where('status','ACTIVE')->where('action_type', 'Update')->first();


							EmployeeApproval::where('id',$employee_infos->id)
							->update([
								//'employee_code'	=>  $emp_code,
								'action_type' => "Create",
								'approval_status_id'	=>  $approver_checker->next_state,
								'approved_at_2' => date('Y-m-d H:i:s'), 
								'approved_by_2' => CRUDBooster::myId()
							]);


							Employee::where('id',$employee_infos->id)
							->update([
								//'employee_code'	=>  $emp_code,
								'action_type' => "Create",
								'channel_id'	=>   $employee_infos->channel_id,
								'customer_type'	=>   $employee_infos->customer_type,
								'customer_location_name'	=>  $employee_infos->customer_location_name,
								'bill_to'	=>  $employee_infos->bill_to,
								'address_line1'	=>  $employee_infos->address_line1,
								'building_no'	=>  $employee_infos->building_no,
								'lot_blk_no_streetname'	=>  $employee_infos->lot_blk_no_streetname,
								'barangay'	=>  $employee_infos->barangay,
								'city_id'	=>  $employee_infos->city_id,
								'state_id'	=>  $employee_infos->state_id,
								'area_code_zip_code'	=>  $employee_infos->area_code_zip_code,
								'country_id'	=>  $employee_infos->country_id,
								'contact_person'	=>  $employee_infos->contact_person,
								'contact_person_ln'	=>  $employee_infos->contact_person_ln,
								'contact_person_fn'	=>  $employee_infos->contact_person_fn,
								'contact_designation_id'	=>  $employee_infos->contact_designation_id,
								'contact_department_id'	=>  $employee_infos->contact_department_id,
								'contact_landline_no'	=>  $employee_infos->contact_landline_no,
								'international_country_code_1'	=>  $employee_infos->international_country_code_1,
								'area_code_1'	=>  $employee_infos->area_code_1,
								'number_1'	=>  $employee_infos->number_1,
								'mobile_number'	=>  $employee_infos->mobile_number,
								'international_country_code_2'	=>  $employee_infos->international_country_code_2,
								'area_code_2'	=>  $employee_infos->area_code_2,
								'number_2'	=>  $employee_infos->number_2,
								'email_address'	=>  $employee_infos->email_address,
								'bank_details'	=>  $employee_infos->bank_details,
								'beneficiary_name'	=>  $employee_infos->beneficiary_name,
								'account_number'	=>  $employee_infos->account_number,
								'beneficiary_address'	=>  $employee_infos->beneficiary_address,
								'bank_beneficiary'	=>  $employee_infos->bank_beneficiary,
								'bank_address'	=>  $employee_infos->bank_address,
								'bank_code'	=>  $employee_infos->bank_code,
								'switf_code'	=>  $employee_infos->switf_code,
								'bic'	=>  $employee_infos->bic,
								'iban'	=>  $employee_infos->iban,
								'aba'	=>  $employee_infos->aba,
								'currency_id'	=>  $employee_infos->currency_id,
								'credit_limit'	=>  $employee_infos->credit_limit,
								'payment_terms_id'	=>  $employee_infos->payment_terms_id,
								'payment_mode_id'	=>  $employee_infos->payment_mode_id,
								'status_id'	=>  $employee_infos->status_id,
								'approved_by_1'	=>  $employee_infos->approved_by_1,
								'approved_at_1'	=>  $employee_infos->approved_at_1,
								'disapproved_at_1'	=>  $employee_infos->disapproved_at_1,
								'approval_status_id'	=>  $approver_checker->next_state,
								'approved_at_2' => date('Y-m-d H:i:s'), 
								'approved_by_2' => CRUDBooster::myId()
							]);


							$config['content'] = CRUDBooster::myName(). " has approved your Employee Edited with Employee Code ".$employee_infos->employee_code." at Employee For Approval Module!";
							$config['to'] = CRUDBooster::adminPath('employee_module/detail/'.$employee_infos->id);
							$config['id_cms_users'] = [$employee_infos->updated_by];	
							CRUDBooster::sendNotification($config);	
							CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Employee(s)  has been approved successfully !","success");

						}

				}

			}elseif($button_name == 'DISAPPROVE') {

				foreach ($employee_info as $employee_infos){

					EmployeeApproval::where('id',$employee_infos->id)
					->update([
						//'supplier_code'	=>  $sup_code,
						'approval_status_id'	=> 404,
						'disapproved_at_2' => date('Y-m-d H:i:s'), 
						'approved_by_2' => CRUDBooster::myId()
					]);

					Employee::where('id',$employee_infos->id)
					->update([
						//'supplier_code'	=>  $sup_code,
						//'approval_status_id'	=> 404,
						'disapproved_at_2' => date('Y-m-d H:i:s'), 
						'approved_by_2' => CRUDBooster::myId()
					]);


					$config['content'] = CRUDBooster::myName(). " has disapproved your edited Employee at Employee For Approval Module!";
					$config['to'] = CRUDBooster::adminPath('employee_approval/edit/'.$employee_infos->id);
					$config['id_cms_users'] = [$employee_infos->approved_by_1];	
					CRUDBooster::sendNotification($config);	

					
					CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Employee(s)  has been disapproved successfully !","warning");
				}

			}
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
			if(CRUDBooster::isSuperadmin()){
				$query->where(function($sub_query){
					$module_id = DB::table('cms_moduls')->where('controller','AdminEmployeeModuleController')->value('id');
					$data_status 		= Statuses::where('status_description', 'ACTIVE')->value('id');
					//$create_customer_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('cms_moduls_id', 'LIKE', '%' . $module_id  . '%')->value('current_state');
					//$update_customer_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('cms_moduls_id', 'LIKE', '%' . $module_id  . '%')->value('current_state');
					
					//$sub_query->where('supplier_approval.approval_status_id',    $create_customer_status)->where('supplier.status_id', 	$data_status);
					//$sub_query->orWhere('supplier_approval.approval_status_id',  $update_customer_status)->where('supplier.status_id', 	$data_status);
					//$sub_query->orWhere('supplier_approval.approval_status_id', 404)->where('supplier.status_id', 	$data_status);
					$approver_get = ApprovalWorkflowSetting::where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
					->where('status','ACTIVE')->get();

					$status_array = array();
					foreach($approver_get as $approver){
						if(!in_array($approver->current_state,	$status_array)){
						   array_push($status_array, $approver->current_state);
						}
					}
					array_push($status_array, "404");

					$status_string = implode(",",$status_array);
					$status = array_map('intval',explode(",",$status_string));

					$sub_query->whereIn('employee_approval.approval_status_id',	 $status)->where('employee_approval.status_id', 	$data_status);

				});
			}elseif(CRUDBooster::myPrivilegeName() == "Requestor"){

				$query->where(function($sub_query){
					$module_id = DB::table('cms_moduls')->where('controller','AdminEmployeeModuleController')->value('id');
					
					$data_status 		= Statuses::where('status_description', 'ACTIVE')->value('id');

					$encoder_checker = ApprovalWorkflowSetting::
					where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
					->where('status','ACTIVE')->get();	

					$approval_array = array();
							foreach($encoder_checker as $approver){

								if(!in_array($approver->current_state,	$approval_array)){
									array_push($approval_array, $approver->current_state);
								}
										//array_push($status_array, $approver->current_state);
							}
							array_push($approval_array, "404");
									
					$approval_string = implode(",",$approval_array);
					$encoder_status = array_map('intval',explode(",",$approval_string));

					//dd($encoder_status);

					$sub_query->whereIn('employee_approval.approval_status_id',	$encoder_status)->where('employee_approval.created_by',	CRUDBooster::myId())->where('employee_approval.status_id', 	$data_status)->where('employee_approval.action_type', "Create");
				});

			}else{	
				$query->where(function($sub_query){

					$module_id = DB::table('cms_moduls')->where('controller','AdminEmployeeModuleController')->value('id');
					
					$data_status 		= Statuses::where('status_description', 'ACTIVE')->value('id');
					
					$approver_checker = ApprovalWorkflowSetting::
										 where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
										->where('approver_privilege_id',CRUDBooster::myPrivilegeId())
										->where('status','ACTIVE')->get();	
					$status_array = array();

					$requestor_array = array();

					foreach($approver_checker as $approver){
						if(!in_array($approver->current_state,	$status_array)){
							array_push($status_array, $approver->current_state);
						}
						if(!in_array($approver->encoder_privilege_id,	$requestor_array)){
							array_push($requestor_array, $approver->encoder_privilege_id);
						}
					}
					array_push($requestor_array, CRUDBooster::myPrivilegeId());

					$status_string = implode(",",$status_array);
					$status = array_map('intval',explode(",",$status_string));
					$requestor_string = implode(",",$requestor_array);
					$requestor = array_map('intval',explode(",",$requestor_string));
					
					$sub_query->whereIn('employee_approval.approval_status_id',	 $status)->whereIn('employee_approval.encoder_privilege_id', 	$requestor)->where('employee_approval.status_id', 	$data_status);
					$sub_query->orwhere('employee_approval.approval_status_id', 404)->where('employee_approval.encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('employee_approval.status_id', 	$data_status);	
					$sub_query->orwhere('employee_approval.action_type', "Update")->where('employee_approval.encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('employee_approval.status_id', 	$data_status);
				});
			}   
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
			if($column_index == 3){
				if(CRUDBooster::myPrivilegeName() == 'Approver'){
						switch ($column_value){
								case 404:
									$column_value = '<span stye="display: block;" class="label label-danger">REJECTED</span><br>';
									break;
								default:
									$column_value = '<span stye="display: block;" class="label label-warning">PENDING</span><br>';
									break;
						}
				}else{
						switch ($column_value){
									case 2:
										$column_value = '<span stye="display: block;" class="label label-info">EDITED</span><br>';
										break;
									case 404:
										$column_value = '<span stye="display: block;" class="label label-danger">REJECTED</span><br>';
										break;
									default:
										$column_value = '<span stye="display: block;" class="label label-warning">PENDING</span><br>';
										break;
						}
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
			$postdata["created_by"]=CRUDBooster::myId();
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
			$module_id = DB::table('cms_moduls')->where('controller','AdminEmployeeModuleController')->value('id');
			
			$supplier_data = EmployeeApproval::where('id',$id)->first();

			$approver_checker = ApprovalWorkflowSetting::where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
								->where('approver_privilege_id', CRUDBooster::myPrivilegeId())
								->where('status','ACTIVE')->first();

			if($supplier_data->action_type == "Update")	{
				
				$postdata['updated_by']	= CRUDBooster::myId();
				$postdata['updated_at']	= date('Y-m-d H:i:s');
				$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('current_state');

			}else{
				switch($approver_checker->workflow_number){

					case 1:
						$postdata["encoder_privilege_id"]		=CRUDBooster::myPrivilegeId();
						$postdata["approved_by_1"]				=CRUDBooster::myId();
						$postdata["approved_at_1"]				=date('Y-m-d H:i:s');

						if($supplier_data->action_type == "Create"){
							$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('next_state');
						}else{
							$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('next_state');
						}
					

					break;
					
					case 2:
						$postdata["encoder_privilege_id"]		=CRUDBooster::myPrivilegeId();
						$postdata["approved_by_2"]				=CRUDBooster::myId();
						$postdata["approved_at_2"]				=date('Y-m-d H:i:s');

						if($supplier_data->action_type == "Create"){
							$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 2)->where('action_type', 'Create')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('next_state');
						}else{
							$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 2)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('next_state');
						}

					break;

					default:

					break;

				}		
			}
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
			$module_id = DB::table('cms_moduls')->where('controller','AdminEmployeeModuleController')->value('id');
			
			$supplier_data = EmployeeApproval::where('id',$id)->first();

			$approver_checker = ApprovalWorkflowSetting::where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
								->where('approver_privilege_id', CRUDBooster::myPrivilegeId())
								->where('status','ACTIVE')->first();

				switch($approver_checker->workflow_number){

					case 1:

							$for_approval 	= EmployeeApproval::where('id',$id)->first();
							$action = $supplier_data->action_type;

							if($action == "Create"){
								$approvers 		= ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Create')
													->where('workflow_number', 2)
													->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->get();
							}else{
								$approvers 		= ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Update')
													->where('workflow_number', 2)
													->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->get();								
							}

							foreach ($approvers as $approvers_list){

								$approver_privilege_for =	DB::table('cms_privileges')->where('id',$approvers_list->encoder_privilege_id)->first();
								$approver_privilege =		DB::table('cms_privileges')->where('id',$approvers_list->approver_privilege_id)->first();	

								if($for_approval->encoder_privilege_id == $approver_privilege_for->id){
									$send_to =	DB::table('cms_users')->where('id_cms_privileges',$approver_privilege->id)->get();
									foreach ($send_to as $send_now){

											$config['content'] =  CRUDBooster::myName(). " has edited Employee with Customer/Location Name ".$for_approval->customer_location_name." at Employee For Approval Module!";

										$config['to'] = CRUDBooster::adminPath('employee_approval?q='.$for_approval->id);
										$config['id_cms_users'] = [$send_now->id];
										CRUDBooster::sendNotification($config);	
									}

								}
								
							}

							$config['content'] = CRUDBooster::myName(). " has edited your Employee created at Employee For Approval Module and Pending for final approval!";
							$config['to'] = CRUDBooster::adminPath('employee_approval?q='.$supplier_data->id);
	
							if($action == "Create"){
								$config['id_cms_users'] = [$supplier_data->created_by];
							}
							else{
								$config['id_cms_users'] = [$supplier_data->updated_by];
							}
	
							CRUDBooster::sendNotification($config);

							CRUDBooster::redirect(CRUDBooster::mainpath(),"Employee has been edited and pending for approval.","info");

					break;
					
					case 2:
						$postdata["approved_by_2"]		=CRUDBooster::myId();
						$postdata["approved_at_2"]		=date('Y-m-d H:i:s');

						if($supplier_data->action_type == "Create"){
							$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 2)->where('action_type', 'Create')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('next_state');
						}else{
							$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 2)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('next_state');
						}

					break;

					default:
					break;

			}	

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



		public function getEdit($id) {

			$module_id = DB::table('cms_moduls')->where('controller','AdminEmployeeModuleController')->value('id');
		    
			$item_info = EmployeeApproval::find($id);

			//$create_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			//$supplier_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			$created_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');

			//dd($created_update_status);
			if ($item_info->approval_status_id == $created_update_status) {
				CRUDBooster::redirect(CRUDBooster::mainpath(""),"You're not allowed to edit pending items for approval.","warning");
			}
			
			return parent::getEdit($id);
		}

	}