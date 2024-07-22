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

	class AdminBrandApprovalController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "id";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = false;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = true;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "brand_approval";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			//$this->col[] = ["label"=>"Brand ID","name"=>"brand_ref"];
			$this->col[] = ["label"=>"Action Type","name"=>"action_type"];
			$this->col[] = ["label"=>"Approval Status","name"=>"approval_status_id"];
			$this->col[] = ["label"=>"Brand Code","name"=>"brand_code"];
			$this->col[] = ["label"=>"Brand Description","name"=>"brand_description"];
			$this->col[] = ["label"=>"Brand For","name"=>"system_description"];
			$this->col[] = ["label"=>"Brand Status","name"=>"brand_status"];	
			$this->col[] = ["label"=>"Created By","name"=>"created_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Created Date","name"=>"created_at"];
			$this->col[] = ["label"=>"Updated By","name"=>"updated_by","join"=>"cms_users,name"];
			$this->col[] = ["label"=>"Updated Date","name"=>"updated_at"];
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
				$this->form[] = ["label"=>"Updated By","name"=>"updated_by",'type'=>'select',"datatable"=>"cms_users,name"];
				$this->form[] = ["label"=>"Updated Date","name"=>"updated_at"];
				//$this->form[] = ["label"=>"Approved By","name"=>"approved_by_2",'type'=>'select',"datatable"=>"cms_users,name"];
				//$this->form[] = ["label"=>"Approved Date","name"=>"approved_at_2"];
			}
			# END FORM DO NOT REMOVE THIS LINE

			# OLD START FORM
			//$this->form = [];
			//$this->form[] = ["label"=>"Action Type","name"=>"action_type","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
			//$this->form[] = ["label"=>"Approval Status Id","name"=>"approval_status_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"approval_status,id"];
			//$this->form[] = ["label"=>"System Id","name"=>"system_id","type"=>"select2","required"=>TRUE,"validation"=>"required|integer|min:0","datatable"=>"system,database_name"];
			//$this->form[] = ["label"=>"Brand Ref","name"=>"brand_ref","type"=>"text","required"=>TRUE,"validation"=>"required|min:1|max:255"];
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
			//$this->form[] = ["label"=>"edited By","name"=>"edited_by","type"=>"number","required"=>TRUE,"validation"=>"required|integer|min:0"];
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
			| @parent_columns = Sparate with comma, e.g : name,edited_at
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
			$module_id = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');
			
			$brand_info = BrandApproval::whereIn('id',$id_selected)->get();
			
			if($button_name == 'APPROVE') {

				foreach ($brand_info as $brand_infos){

						if($brand_infos->action_type == "Create"){

							$approver_checker = ApprovalWorkflowSetting::where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
							->where('approver_privilege_id',CRUDBooster::myPrivilegeId())
							->where('workflow_number', 1)
							->where('status','ACTIVE')->where('action_type', 'Create')->first();

							//dd($approver_checker->next_state);



							BrandApproval::where('id',$brand_infos->id)
							->update([
								//'supplier_code'	=>  $sup_code,
								'action_type' => "Create",
								'approval_status_id'	=>  $approver_checker->next_state,
								'approved_at_1' => date('Y-m-d H:i:s'), 
								'approved_by_1' => CRUDBooster::myId()
							]);
		
							Brand::where('id',$brand_infos->id)
							->update([
								//'supplier_code'	=>  $sup_code,
								//'approval_status_id'	=> 404,
										'action_type' => "Create",
										'system_id'	=>  $brand_infos->system_id,
										'system_description'	=>  $brand_infos->system_description,
										'brand_ref'	=>  $brand_infos->brand_ref,
										'brand_code'	=>  $brand_infos->brand_code,
										'brand_description'	=>  $brand_infos->brand_description,
										'brand_beacode'	=>  $brand_infos->brand_beacode,
										'brand_type_id'	=>  $brand_infos->brand_type_id,
										'brand_status'	=>  $brand_infos->brand_status,
										'approved_by_1'	=>  $brand_infos->approved_by_1,
										'approved_at_1'	=>  $brand_infos->approved_at_1,
										'disapproved_at_1'	=>  $brand_infos->disapproved_at_1,
										'approval_status_id'	=>  $approver_checker->next_state,
										'approved_at_2' => date('Y-m-d H:i:s'), 
										'approved_by_2' => CRUDBooster::myId()
							]);


							/*if($brand_infos->system_id == 1){

								DB::connection('mysql_dimfs')

								->statement('insert into brands 
											(	brand_code,
												brand_description,
												status,
												created_by,
												created_at)
												values (?, ?, ?, ?, ?)', 
											[	
												$brand_infos->brand_code, 
												$brand_infos->brand_description,
												"ACTIVE",
												CRUDBooster::myId(),
												date('Y-m-d H:i:s')

											]);

								DB::disconnect('mysql_dimfs');

							}else{

								DB::connection('mysql_aimfs')

								->statement('insert into brand 
											(	brand_code,
												brand_description,
												brand_status,
												created_by,
												created_at)
												values (?, ?, ?, ?, ?)', 
											[	
												$brand_infos->brand_code, 
												$brand_infos->brand_description,
												"ACTIVE",
												CRUDBooster::myId(),
												date('Y-m-d H:i:s')
												
											]);

								DB::disconnect('mysql_aimfs');

							}*/


							$config['content'] = CRUDBooster::myName(). " has approved your created Brand at Brand For Approval Module!";
							$config['to'] = CRUDBooster::adminPath('brand_module/detail/'.$brand_infos->id);
							$config['id_cms_users'] = [$brand_infos->created_by];	
							CRUDBooster::sendNotification($config);	
		
							
							CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Brand(s) has been approved successfully !","success");
							
						}else{

							$approver_checker = ApprovalWorkflowSetting::where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')
							->where('approver_privilege_id',CRUDBooster::myPrivilegeId())
							->where('workflow_number', 2)
							->where('status','ACTIVE')->where('action_type', 'Update')->first();


							BrandApproval::where('id',$brand_infos->id)
							->update([
								//'supplier_code'	=>  $sup_code,
								'action_type' => "Create",
								'approval_status_id'	=>  $approver_checker->next_state,
								'approved_at_2' => date('Y-m-d H:i:s'), 
								'approved_by_2' => CRUDBooster::myId()
							]);
		
							Brand::where('id',$brand_infos->id)
							->update([
								//'supplier_code'	=>  $sup_code,
								//'approval_status_id'	=> 404,
								        'action_type' => "Create",
										'system_id'	=>  $brand_infos->system_id,
										'system_description'	=>  $brand_infos->system_description,
										'brand_ref'	=>  $brand_infos->brand_ref,
										'brand_code'	=>  $brand_infos->brand_code,
										'brand_description'	=>  $brand_infos->brand_description,
										'brand_beacode'	=>  $brand_infos->brand_beacode,
										'brand_type_id'	=>  $brand_infos->brand_type_id,
										'brand_status'	=>  $brand_infos->brand_status,
										'approved_by_1'	=>  $brand_infos->approved_by_1,
										'approved_at_1'	=>  $brand_infos->approved_at_1,
										'disapproved_at_1'	=>  $brand_infos->disapproved_at_1,
										'approval_status_id'	=>  $approver_checker->next_state,
										'approved_at_2' => date('Y-m-d H:i:s'), 
										'approved_by_2' => CRUDBooster::myId()
							]);

							$config['content'] = CRUDBooster::myName(). " has approved your edited Brand at Brand For Approval Module!";
							$config['to'] = CRUDBooster::adminPath('brand_module/detail/'.$brand_infos->id);
							$config['id_cms_users'] = [$brand_infos->created_by];	
							CRUDBooster::sendNotification($config);	
		
							CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Brand(s) has been approved successfully !","success");

						}

				}

			}elseif($button_name == 'DISAPPROVE') {

				foreach ($brand_info as $brand_infos){

					BrandApproval::where('id',$brand_infos->id)
					->update([
						//'supplier_code'	=>  $sup_code,
						'approval_status_id'	=> 404,
						'disapproved_at_1' => date('Y-m-d H:i:s'), 
						'approved_by_1' => CRUDBooster::myId()
					]);

					Brand::where('id',$brand_infos->id)
					->update([
						//'supplier_code'	=>  $sup_code,
						//'approval_status_id'	=> 404,
						'disapproved_at_1' => date('Y-m-d H:i:s'), 
						'approved_by_1' => CRUDBooster::myId()
					]);


					$config['content'] = CRUDBooster::myName(). " has disapproved your edited Brand at Brand For Approval Module!";
					$config['to'] = CRUDBooster::adminPath('brand_approval/edit/'.$brand_infos->id);
					$config['id_cms_users'] = [$brand_infos->created_by];	
					CRUDBooster::sendNotification($config);	

					
					CRUDBooster::redirect(CRUDBooster::mainpath(""),"The Brand(s) has been disapproved successfully !","warning");
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
					$module_id = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');
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
					
					//dd( $status);


					$sub_query->whereIn('brand_approval.approval_status_id',	 $status);//->where('brand_approval.status_id', 	$data_status);

				});
			}elseif(CRUDBooster::myPrivilegeName() == "Requestor"){

				$query->where(function($sub_query){
					$module_id = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');
					
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

					$sub_query->whereIn('brand_approval.approval_status_id',	$encoder_status)->where('brand_approval.created_by',CRUDBooster::myId());
				});

			}else{	
				$query->where(function($sub_query){

					$module_id = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');
					
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
					//dd( $status);
					$sub_query->whereIn('brand_approval.approval_status_id',	 $status)->whereIn('brand_approval.encoder_privilege_id', 	$requestor);
					//$sub_query->orwhere('brand_approval.approval_status_id', 404)->where('brand_approval.approved_by_1', CRUDBooster::myPrivilegeId());	
					//$sub_query->orwhere('brand_approval.action_type', "Update")->where('brand_approval.approved_by_1', CRUDBooster::myPrivilegeId());
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

			if($column_index == 6){

				$action = explode(";", $column_value);

				foreach ($action as $value) {
					$show .= '<span stye="display: block;" class="label label-info">'.$value.'</span><br>';
				}

				$column_value = $show;
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
			$postdata["edited_by"]=CRUDBooster::myId();
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

			$customer_data = BrandApproval::where('id',$id)->first();

			if($customer_data->action_type == "Update")	{

				$postdata['updated_by']	= CRUDBooster::myId();
				$postdata['updated_at']	= date('Y-m-d H:i:s');
				$postdata['approval_status_id']	=ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' .$module_id . '%')->value('current_state');

			}else{	
			
						$module_ids = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');


						$module_id = array();

						$a =   explode(";", $postdata["system_description"]);

						foreach($a as $value){

							array_push($module_id, DB::table('system')->where('system_description',$value)->value('id'));
						}
						$postdata["system_id"] 					= implode(",", $module_id);
						$postdata["encoder_privilege_id"]		= CRUDBooster::myPrivilegeId();
						$postdata['approval_status_id']			= ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_ids . '%')->value('current_state');
						$postdata["updated_by"]					= CRUDBooster::myId();



						BrandApproval::where('id',$brand_infos->id)
						->update([
							//'supplier_code'	=>  $sup_code,
							'system_id'	=> implode(",", $module_id),
							'encoder_privilege_id' => CRUDBooster::myPrivilegeId(), 
							'approval_status_id' => ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_ids . '%')->value('current_state'),
							'updated_by' => CRUDBooster::myId(),
							'updated_at' => date('Y-m-d H:i:s'),
							'brand_code' => $postdata["brand_code"],
							'brand_description' => $postdata["brand_description"],
							'system_description' => $postdata["system_description"],
							'brand_status' => $postdata["brand_status"]
						]);
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
			$module_id = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');
			
			$for_approval = BrandApproval::where('id',$id)->first();
			$approvers = ApprovalWorkflowSetting::where('status','ACTIVE')->where('action_type', 'Create')
			->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->get();

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
				
			}

			CRUDBooster::redirect(CRUDBooster::mainpath(),"Brand has been edited and pending for approval.","info");
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

		    $module_id = DB::table('cms_moduls')->where('controller','AdminBrandController')->value('id');
		    
			$item_info = BrandApproval::find($id);

			//$create_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			//$supplier_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('approver_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			$created_update_status = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Update')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');

			$create = ApprovalWorkflowSetting::where('workflow_number', 1)->where('action_type', 'Create')->where('encoder_privilege_id', CRUDBooster::myPrivilegeId())->where('cms_moduls_id', 'LIKE', '%' . $module_id . '%')->value('current_state');
			//dd($created_update_status);
			if ($item_info->approval_status_id == $created_update_status) {
				CRUDBooster::redirect(CRUDBooster::mainpath(""),"You're not allowed to edit pending items for approval.","warning");
			}

			if ($item_info->approval_status_id == $create) {
				CRUDBooster::redirect(CRUDBooster::mainpath(""),"You're not allowed to edit pending items for approval.","warning");
			}
			
			return parent::getEdit($id);
		}


	}