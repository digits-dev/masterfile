<?php namespace App\Http\Controllers;

	use Session;
	use Illuminate\Http\Request;
	use DB;
	use CRUDBooster;
	use Illuminate\Support\Facades\Hash;
	use Illuminate\Foundation\Validation\ValidatesRequests;
	use Illuminate\Support\Facades\Input;
	use Illuminate\Support\Facades\Config;

	class AdminUserSystemAccountsController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "name";
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
			$this->button_export = true;
			$this->table = "user_system_accounts";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$this->col = [];
			$this->col[] = ["label"=>"Name","name"=>"name"];
			$this->col[] = ["label"=>"Email","name"=>"email"];
			$this->col[] = ["label"=>"Status","name"=>"status"];
			$this->col[] = ["label"=>"System","name"=>"system"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'First Name','name'=>'first_name','type'=>'text','validation'=>'required|string|min:3|max:150','width'=>'col-sm-6','placeholder'=>'You can only enter letters only'];
			$this->form[] = ['label'=>'Last Name','name'=>'last_name','type'=>'text','validation'=>'required|string|min:3|max:150','width'=>'col-sm-6','placeholder'=>'You can only enter letters only'];
			
			$this->form[] = ['label'=>'Email','name'=>'email','type'=>'email','validation'=>'required|min:1|max:150|email|unique:user_system_accounts','width'=>'col-sm-6','placeholder'=>'Please enter a valid email address'];
			
			$this->form[] = ['label'=>'System','name'=>'system','type'=>'textarea','validation'=>'required','width'=>'col-sm-6'];
			$this->form[] = ['label'=>'Status','name'=>'status','type'=>'select','validation'=>'required','width'=>'col-sm-6','dataenum'=>'ACTIVE;INACTIVE'];
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
            $this->button_selected[] = ['label'=>'Deactivate Account','icon'=>'fa fa-user','name'=>'deactivate_account'];
	                
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
	        
	        if($button_name == "deactivate_account"){
	            $systemLists = DB::table('system')->where('status','ACTIVE')->get();
	            foreach($id_selected as $keyId => $valId ){
	                $userAccount = DB::table('user_system_accounts')->where('id',$valId)->first();
	                $userSystem = explode(",", $userAccount->system);
	                
				    foreach($systemLists as $key_sys => $value_sys){

    					$dbConnection = [
    						'driver' => 'mysql',
    						'host' => $value_sys->host,
    						'database' => $value_sys->database_name,
    						'username' => $value_sys->username,
    						'password' => $value_sys->db_password,
    						'port' => $value_sys->port,
    						'charset'   => 'utf8',
    						'collation' => 'utf8_unicode_ci',
    						'prefix'    => '',
    						'strict'    => false];
    						
    					Config::set('database.connections.'.$value_sys->system_code, $dbConnection);
    
    					if(in_array($value_sys->system_code, $userSystem)){
    					    
    						DB::connection($value_sys->system_code)
    							->table('cms_users')
    							->where('email',$userAccount->email)
    							->update(
    							[
    								'status' => 'INACTIVE', 
    								'password' => Hash::make(rand())
    							]);
    						DB::disconnect($value_sys->system_code);
    					}
				    }
			    }
	            DB::table('user_system_accounts')->whereIn('id',$id_selected)->update([
	                'status' => 'INACTIVE',
	                'password' => Hash::make(rand())
	            ]);
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
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
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
            $password = Hash::make('qwerty');
            $systems = $postdata["system"];
            $postdata["name"] = $postdata["first_name"]." ".$postdata["last_name"];
            $postdata["password"] = $password;
            $postdata["system"] = implode(",",$systems);
            
            $systemLists = DB::table('system')->where('status','ACTIVE')->get();
			foreach ($systems as $key => $value) {
				foreach($systemLists as $key_sys => $value_sys){

					$dbConnection = [
						'driver' => 'mysql',
						'host' => $value_sys->host,
						'database' => $value_sys->database_name,
						'username' => $value_sys->username,
						'password' => $value_sys->db_password,
						'port' => $value_sys->port,
						'charset'   => 'utf8',
						'collation' => 'utf8_unicode_ci',
						'prefix'    => '',
						'strict'    => false];
						
					Config::set('database.connections.'.$value_sys->system_code, $dbConnection);

					if($value == $value_sys->system_code){
					    
						DB::connection($value_sys->system_code)
							->table('cms_users')
							->updateOrInsert(['email' => $postdata["email"]],
							[
							    'first_name' => $postdata["first_name"],
							    'last_name' => $postdata["last_name"],
							    'name' => $postdata["name"],
								'email' => $postdata["email"],
								'status' => 'ACTIVE', 
								'password' => $password
							]);
						DB::disconnect($value_sys->system_code);
					}
				}
			}
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
	        $systems = $postdata["system"];
	        $postdata["name"] = $postdata["first_name"]." ".$postdata["last_name"];
	        $systemLists = DB::table('system')->where('status','ACTIVE')->whereIn('system_code',$postdata['system'])->get();
			foreach ($systems as $key => $value) {
				foreach($systemLists as $key_sys => $value_sys){

					$dbConnection = [
						'driver' => 'mysql',
						'host' => $value_sys->host,
						'database' => $value_sys->database_name,
						'username' => $value_sys->username,
						'password' => $value_sys->db_password,
						'port' => $value_sys->port,
						'charset'   => 'utf8',
						'collation' => 'utf8_unicode_ci',
						'prefix'    => '',
						'strict'    => false];
						
					Config::set('database.connections.'.$value_sys->system_code, $dbConnection);

					if($value == $value_sys->system_code){
					    $existing = DB::connection($value_sys->system_code)
							->table('cms_users')->where('email', $postdata["email"])->first();
							
						if(empty($existing)){
						    DB::connection($value_sys->system_code)
							->table('cms_users')
							->insert(
							[
							    'first_name' => $postdata["first_name"],
							    'last_name' => $postdata["last_name"],
							    'name' => $postdata["name"],
								'email' => $postdata["email"],
								'status' => 'ACTIVE', 
								'password' => Hash::make('qwerty')
							]);
						}
						else{
						    DB::connection($value_sys->system_code)
							->table('cms_users')
							->where('email', $postdata["email"])
							->update(
							[
							    'first_name' => $postdata["first_name"],
							    'last_name' => $postdata["last_name"],
							    'name' => $postdata["name"]
							]);
						}
						
						DB::disconnect($value_sys->system_code);
					}
				}
			}
			
			$postdata["system"] = implode(",",$systems);
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
	    
	    public function getAdd() {
			//Create an Auth
			if(!CRUDBooster::isCreate() && $this->global_privilege==FALSE || $this->button_add==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = 'Create User';
			$data['systems'] = DB::table('system')->select('system_code')->where('status','ACTIVE')->get();

			return view('users-system.create_form',$data);
		}
		
		public function getEdit($id) {
			//Create an Auth
			if(!CRUDBooster::isUpdate() && $this->global_privilege==FALSE || $this->button_edit==FALSE) {    
				CRUDBooster::redirect(CRUDBooster::adminPath(),trans("crudbooster.denied_access"));
			}
			
			$data = [];
			$data['page_title'] = 'Edit User';
			$data['systems'] = DB::table('system')->select('system_code')->where('status','ACTIVE')->get();
			$data['row'] = DB::table('user_system_accounts')->where('id',$id)->first();

			
			return view('users-system.edit_form',$data);
		}
		
		public function getAllUsers(){
		    $systemLists = DB::table('system')->where('status','ACTIVE')->get();
		    ini_set('max_execution_time', '1000');
			foreach($systemLists as $key_sys => $value_sys){

					$dbConnection = [
						'driver' => 'mysql',
						'host' => $value_sys->host,
						'database' => $value_sys->database_name,
						'username' => $value_sys->username,
						'password' => $value_sys->db_password,
						'port' => $value_sys->port,
						'charset'   => 'utf8',
						'collation' => 'utf8_unicode_ci',
						'prefix'    => '',
						'strict'    => false];
						
					Config::set('database.connections.'.$value_sys->system_code, $dbConnection);

					$users = DB::connection($value_sys->system_code)
						->table('cms_users')->get();
						
					$system = $value_sys->system_code;
					ini_set('max_execution_time', '1000');
					foreach($users as $keyUser => $valueUser){
					    $existingUser = DB::table('user_system_accounts')->where('email' , $valueUser->email)->first();
					    
					    DB::table('user_system_accounts')
						->updateOrInsert(['email' => $valueUser->email],
						[
						    'first_name' => strtoupper($valueUser->first_name),
						    'last_name' => strtoupper($valueUser->last_name),
						    'name' => strtoupper($valueUser->name),
							'email' => $valueUser->email,
							'status' => $valueUser->status, 
							'password' => Hash::make('qwerty'),
							'system' => (!empty($existingUser)) ? $existingUser->system.','.$system  : $system
						]);
					}
						
					DB::disconnect($value_sys->system_code);
					
				}
				
			CRUDBooster::redirect(CRUDBooster::mainpath(),"Fetch all users from all system!","success");
			
		}


	}