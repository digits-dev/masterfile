<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('admin/login');
    //return view('welcome');
});

Route::group(['middleware' => ['web']], function() {
    //item master
    Route::get('admin/item_masters/getBrandData/{id}','AdminItemMastersController@getBrandData')->name('getBrandData');
    Route::get('admin/item_masters/getEdit/{id}','AdminItemMastersController@getEdit');
    //subcategory master
    Route::get('admin/subcategories/getCategoryCode/{id}','AdminSubcategoriesController@getCategoryCode');
    //item export
	Route::get('admin/item_masters/bartender','AdminItemMastersController@exportBartender')->name('bartender');
	Route::get('admin/item_masters/posformat','AdminItemMastersController@exportPOSFormat')->name('posformat');
	Route::get('admin/item_masters/myobformat','AdminItemMastersController@exportMYOBFormat')->name('myobformat');
	Route::get('admin/item_masters/export-excel','AdminItemMastersController@customExportExcel')->name('export-excel');
	
	Route::get('admin/customer_myobs/export-trs','AdminCustomerMyobsController@customExportExcelTRS');
	
	Route::post('/admin/item_masters/upload_sku_legend','AdminItemMastersController@uploadSKULegend')->name('uploadSKULegend');
    Route::get('/admin/item_masters/upload_sku_legend','AdminItemMastersController@getUploadView')->name('getUploadSKULegend');
    Route::get('/admin/item_masters/download-sku-template','AdminItemMastersController@downloadSKULegendTemplate')->name('getSKULegendTemplate');
    
    Route::get('admin/supplier_module/getCity/{id}','AdminSupplierModuleController@getCity')->name('getCity');
    Route::get('admin/supplier_module/getState/{id}','AdminSupplierModuleController@getState')->name('getState');
    Route::get('admin/supplier_module/getCountry/{id}','AdminSupplierModuleController@getCountry')->name('getCountry');

    Route::get('admin/employee_module/getCity/{id}','AdminEmployeeModuleController@getCity')->name('getCity');
    Route::get('admin/employee_module/getState/{id}','AdminEmployeeModuleController@getState')->name('getState');
    Route::get('admin/employee_module/getCountry/{id}','AdminEmployeeModuleController@getCountry')->name('getCountry');

    Route::get('admin/customer_module/getCity/{id}','AdminCustomerModuleController@getCity')->name('getCity');
    Route::get('admin/customer_module/getState/{id}','AdminCustomerModuleController@getState')->name('getState');
    Route::get('admin/customer_module/getCountry/{id}','AdminCustomerModuleController@getCountry')->name('getCountry');
    Route::get('admin/customer_module/getCustomerType/{id}','AdminCustomerModuleController@getCustomerType')->name('getCustomerType');
    Route::get('admin/customer_module/getBranchOnline/{id}','AdminCustomerModuleController@getBranchOnline')->name('getBranchOnline');
    Route::get('admin/customer_module/getBeaStaging/{id}','AdminCustomerModuleController@getBeaStaging')->name('getBeaStaging');

    Route::get('/admin/customer_module/GetExtractCustomerAndLocation','AdminCustomerModuleController@GetExtractCustomerAndLocation')->name('GetExtractCustomerAndLocation');  
    Route::get('/admin/employee_module/GetExtractEmployee','AdminEmployeeModuleController@GetExtractEmployee')->name('GetExtractEmployee'); 

    Route::get('/admin/supplier_module/GetExtractSupplier','AdminSupplierModuleController@GetExtractSupplier')->name('GetExtractSupplier'); 

    Route::get('/admin/brand_module/GetExtractBrand','AdminBrandController@GetExtractBrand')->name('GetExtractBrand'); 
    
    Route::get('/admin/user_system_accounts/getAllUsers','AdminUserSystemAccountsController@getAllUsers')->name('getAllUsers');
    
});