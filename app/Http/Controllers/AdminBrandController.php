<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;
	use App\City;
	use App\State;
	use App\Country;
	use App\Statuses;
	use App\Brand;
	use App\BrandApproval;
	use App\ApprovalWorkflowSetting;
	use App\CustomerTypes;
	use App\Channel;
	use Excel;
	use Carbon\Carbon;
	use PHPExcel_Style_Border;
	use PHPExcel_Style_Fill;

	class AdminBrandController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
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
			$this->table = "brand";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			//$this->col[] = ["label"=>"Brand ID","name"=>"brand_ref"];
			$this->col[] = ["label"=>"Brand Code","name"=>"brand_code"];
			$this->col[] = ["label"=>"Brand Description","name"=>"brand_description"];
			$this->col[] = ["label"=>"Brand For","name"=>"system_description"];
			$this->col[] = ["label"=>"Brand Status","name"=>"brand_status"];	

			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Updated Date","name"=>"updated_at"];
			# END COLUMNS DO NOT REMOVE THIS LINE
	
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];

			$this->form[] = ['label'=>'Brand Code','name'=>'brand_code','type'=>'text','validation'=>'required|min:3|max:3','width'=>'col-sm-5','help'=>'Brand Code must be 3 letter unique code format. (Example: ABC)','placeholder'=>'Brand Code'];
			$this->form[] = ['label'=>'Brand Description','name'=>'brand_description','type'=>'text','validation'=>'required|min:1|max:30','width'=>'col-sm-5','placeholder'=>'Brand Description'];
			$this->form[] = ['label'=>'Brand For','name'=>'system_description','type'=>'checkbox','validation'=>'required','width'=>'col-sm-5','datatable'=>'system,system_description,id'];
		
						
			if(CRUDBooster::getCurrentMethod() == 'getEdit' || CRUDBooster::getCurrentMethod() == 'postEditSave'){

				$this->form[] = ['label'=>'Status','name'=>'brand_status','type'=>'select','validation'=>'required','width'=>'col-sm-5','dataenum'=>'ACTIVE;INACTIVE'];				
			}
			
			if(CRUDBooster::getCurrentMethod() == 'getDetail'){
				$this->form[] = ['label'=>'Status','name'=>'brand_status','type'=>'select','validation'=>'required','width'=>'col-sm-5','dataenum'=>'ACTIVE;INACTIVE'];
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
			//$this->form[] = ["label"=>"Approval Status Id","name"=>"approval_status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"approval_status,id"];
			//$this->form[] = ["label"=>"System Id","name"=>"system_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"system,database_name"];
			//$this->form[] = ["label"=>"Brand Code","name"=>"brand_code","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Brand Description","name"=>"brand_description","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Brand Beacode","name"=>"brand_beacode","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Brand Type Id","name"=>"brand_type_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"brand_type,id"];
			//$this->form[] = ["label"=>"Brand Status","name"=>"brand_status","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Encoder Privilege Id","name"=>"encoder_privilege_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"encoder_privilege,id"];
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
				"icon"=>"fa fa-download","url"=>CRUDBooster::mainpath('GetExtractBrand').'?'.urldecode(http_build_query(@$_GET))];
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
	        $this->load_js[] = asset("js/brand_master.js");
	        
	        
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
				$sub_query->where('brand.approval_status_id', 	$create_item_status);
				$sub_query->orWhere('brand.approval_status_id',	$update_item_status);
				//$sub_query->where('brand.approval_status_id', 	$create_item_status)->where('brand.brand_status', "ACTIVE");
				//$sub_query->orWhere('brand.approval_status_id',	$update_item_status)->where('brand.brand_status', "ACTIVE");

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
			if($column_index == 5){
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
	    public function hook_before_add(&$postdata){        
	        //Your code here
			//$data_status =	 	Statuses::where('status_description', 'ACTIVE')->value('id');

			$module_id = array();

			$a =   explode(";", $postdata["system_description"]);

			foreach($a as $value){

				array_push($module_id, DB::table('system')->where('system_description',$value)->value('id'));
			}
			$postdata["system_id"] = implode(",", $module_id);


			$postdata["created_by"]					= CRUDBooster::myId();
			$postdata["brand_status"]				= "ACTIVE";
			$postdata["action_type"]				="Create";
			$postdata["encoder_privilege_id"]		= CRUDBooster::myPrivilegeId();
			$postdata['approval_status_id']			= ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state');

			/*
			if(implode(",", $module_id) == 1){

				DB::connection('mysql_dimfs')

				->statement('insert into brands 
							(	brand_code,
								brand_description,
								status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')

							]);

				DB::disconnect('mysql_dimfs');

			}else if(implode(",", $module_id) == 2){

				DB::connection('mysql_aimfs')

				->statement('insert into brand 
							(	brand_code,
								brand_description,
								brand_status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')
								
							]);

				DB::disconnect('mysql_aimfs');

			}else{


				DB::connection('mysql_dimfs')

				->statement('insert into brands 
							(	brand_code,
								brand_description,
								status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')

							]);

				DB::disconnect('mysql_dimfs');

				DB::connection('mysql_aimfs')

				->statement('insert into brand 
							(	brand_code,
								brand_description,
								brand_status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')
								
							]);

				DB::disconnect('mysql_aimfs');



			}
			*/
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
			$item_data = Brand::where('id',$id)->get()->toArray();	
			BrandApproval::insert($item_data);

			/*$for_approval = BrandApproval::where('id',$id)->first();
			$approvers = ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Create')
			->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->get();

			foreach ($approvers as $approvers_list){

				$approver_privilege_for =	DB::table('cms_privileges')->where('id',$approvers_list->encoder_privilege_id)->first();
				$approver_privilege =		DB::table('cms_privileges')->where('id',$approvers_list->approver_privilege_id)->first();	

				if($for_approval->encoder_privilege_id == $approver_privilege_for->id){
					$send_to =	DB::table('cms_users')->where('id_cms_privileges',$approver_privilege->id)->get();
					foreach ($send_to as $send_now){


							$config['content'] =  CRUDBooster::myName(). " has created Brand with Brand Code ".$for_approval->brand_code." at Brand Module!";
						

						$config['to'] = CRUDBooster::adminPath('brand_approval?q='.$for_approval->id);
						$config['id_cms_users'] = [$send_now->id];
						CRUDBooster::sendNotification($config);	
					}

				}
				
			}*/

			$brand_data = Brand::where('id',$id)->first();	


			CRUDBooster::redirect(CRUDBooster::mainpath(),"Brand with Brand Code ".$brand_data->brand_code." has been created successfully.","info");

			//CRUDBooster::redirect(CRUDBooster::mainpath(),"Brand has been created and pending for approval.","info");
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

			/*

			$module_id = array();

			$a =   explode(";", $postdata["system_description"]);

			foreach($a as $value){

				array_push($module_id, DB::table('system')->where('system_description',$value)->value('id'));
			}


			BrandApproval::where('id', $id)->update([
				'system_id'				=> implode(",", $module_id),
				'system_description'	=> $postdata["system_description"],
				'brand_code'	=>  $postdata["brand_code"],
				'brand_description'	=> $postdata["brand_description"],
				'brand_status'	=>   $postdata["brand_status"],
				'action_type'	=>  "Update",
				'updated_by'	=>  CRUDBooster::myId(),
				'updated_at'	=>  date('Y-m-d H:i:s'),
				'encoder_privilege_id'	=>  CRUDBooster::myPrivilegeId(),
				'approval_status_id'	=>  ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state')
			]);

			//dd($postdata["brand_description"]);

			unset($postdata);
			unset($this->arr);

			$this->arr["encoder_privilege_id"] = CRUDBooster::myPrivilegeId();
			$this->arr["updated_by"] = CRUDBooster::myId();
			$this->arr["action_type"] = "Update";

			*/



			$module_id = array();

			$a =   explode(";", $postdata["system_description"]);

			foreach($a as $value){

				array_push($module_id, DB::table('system')->where('system_description',$value)->value('id'));
			}

			//dd(implode(",", $module_id));

			$postdata["system_id"] = implode(",", $module_id);

			

			$postdata["updated_by"]				= CRUDBooster::myId();
			$postdata["encoder_privilege_id"]	= CRUDBooster::myPrivilegeId();
			$postdata["action_type"]			= "Update";



			BrandApproval::where('id', $id)->update([
				'system_id'				=> implode(",", $module_id),
				'system_description'	=> $postdata["system_description"],
				'brand_code'	=>  $postdata["brand_code"],
				'brand_description'	=> $postdata["brand_description"],
				'brand_status'	=>   $postdata["brand_status"],
				'action_type'	=>  "Update",
				'updated_by'	=>  CRUDBooster::myId(),
				'updated_at'	=>  date('Y-m-d H:i:s'),
				'encoder_privilege_id'	=>  CRUDBooster::myPrivilegeId(),
				'approval_status_id'	=>  ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->value('current_state')
			]);


			/*
			if(implode(",", $module_id) == 1){

				DB::connection('mysql_dimfs')

				->statement('insert into brands 
							(	brand_code,
								brand_description,
								status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')

							]);

				DB::disconnect('mysql_dimfs');

			}else if(implode(",", $module_id) == 2){

				DB::connection('mysql_aimfs')

				->statement('insert into brand 
							(	brand_code,
								brand_description,
								brand_status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')
								
							]);

				DB::disconnect('mysql_aimfs');

			}else{


				DB::connection('mysql_dimfs')

				->statement('insert into brands 
							(	brand_code,
								brand_description,
								status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')

							]);

				DB::disconnect('mysql_dimfs');

				DB::connection('mysql_aimfs')

				->statement('insert into brand 
							(	brand_code,
								brand_description,
								brand_status,
								created_by,
								created_at)
								values (?, ?, ?, ?, ?)', 
							[	
								$postdata["brand_code"], 
								$postdata["brand_description"],
								"ACTIVE",
								CRUDBooster::myId(),
								date('Y-m-d H:i:s')
								
							]);

				DB::disconnect('mysql_aimfs');



			}
			*/
			
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

			//$brand_info = Brand::where('id',$id)->first();

			/*$for_approval = BrandApproval::where('id',$id)->first();
			$approvers = ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Update')
			->where('cms_moduls_id', 'LIKE', '%' . CRUDBooster::getCurrentModule()->id . '%')->get();

			foreach ($approvers as $approvers_list){

				$approver_privilege_for =	DB::table('cms_privileges')->where('id',$approvers_list->encoder_privilege_id)->first();
				$approver_privilege =		DB::table('cms_privileges')->where('id',$approvers_list->approver_privilege_id)->first();	

				if($for_approval->encoder_privilege_id == $approver_privilege_for->id){
					$send_to =	DB::table('cms_users')->where('id_cms_privileges',$approver_privilege->id)->get();
					foreach ($send_to as $send_now){


							$config['content'] =  CRUDBooster::myName(). " has edited Brand with Brand Code ".$for_approval->brand_code." at Brand Module!";
						

						$config['to'] = CRUDBooster::adminPath('brand_approval?q='.$for_approval->id);
						$config['id_cms_users'] = [$send_now->id];
						CRUDBooster::sendNotification($config);	
					}

				}
				
			}*/

			$brand_data = Brand::where('id',$id)->first();


			CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Brand with Brand Code ".$brand_data->brand_code." has been edited successfully.","info");

			//CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Brand(s) has been edited and pending for approval.","info");
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

		/*
		public function getEdit($id) {

		    $module_id = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');
		    
			$item_info = Brand::find($id);

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


		public function GetExtractBrand() {

            $filename = 'Brand - ' . date("d M Y - h.i.sa");
			$sheetname = 'Brand'.date("d-M-Y");
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

					$orderData = DB::table('brand')
		
					//->leftjoin('statuses', 'brand.status_id','=', 'statuses.id')	
					->leftjoin('cms_users as created', 'brand.created_by','=', 'created.id')
					->leftjoin('cms_users as updated', 'brand.updated_by','=', 'updated.id')
					->select( 	'brand.*', 	
								//'statuses.status_description',
								'created.name as by_created',
								'updated.name as by_updated'
							)->where('brand.brand_status', "ACTIVE");
	
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

					$ordeDataLines = $orderData->orderBy('brand.id','asc')->get();
					$blank_field = '';
					$store_inv = '';
					$counter=0;
					$final_count = count((array)$ordeDataLines) + 1;
					foreach ($ordeDataLines as $orderRow) {
					    $counter++;
			
						$orderItems[] = array(
							//is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toDateString(),	//'APPROVED DATE',
							//is_null($orderRow->approved_at) ? "" : Carbon::parse($orderRow->approved_at)->toTimeString(), //'APPROVED TIME',
							
							$orderRow->brand_code,
							$orderRow->brand_description, 		
							$orderRow->system_description, 	
							$orderRow->brand_status,				
				 			$orderRow->by_created,                
							$orderRow->created_at,
							$orderRow->by_updated,
							$orderRow->updated_at
						);
					}

					$headings = array(
						'Brand Code',
						'Brand Description',
						'Brand For',
						'Brand Status',
						'Created By',       //additional code 20200207
						'Created Date',       //additional code 20200207
						'Updated By',           //blue  //additional code 20200205
						'Updated Date'
					);

					$sheet->fromArray($orderItems, null, 'A1', false, false);
					$sheet->prependRow(1, $headings);

                             
                    $sheet->getStyle('A1:H1')->applyFromArray(array(
                        'fill' => array(
                            'type'  => PHPExcel_Style_Fill::FILL_SOLID,
                            'color' => array('rgb' => '8DB4E2') //141,180,226->8DB4E2
                        )
                    ));
                    $sheet->cells('A1:H1'.$final_count, function($cells) {
                    	$cells->setAlignment('left');
                    	
                    });
 
				});
			})->export('xlsx');
			
		}
	}