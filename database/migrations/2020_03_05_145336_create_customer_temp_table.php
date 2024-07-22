<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerTempTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action_type',10)->nullable();
            $table->tinyInteger('approval_status_id', false, true)->length(3)->unsigned()->nullable();
            $table->string('customer_code',15)->nullable();
            $table->integer('channel_id', false, true)->length(10)->unsigned()->nullable();
            $table->text('note');
            $table->string('cutomer_name', 100)->nullable();
            $table->string('concat_mall_branch', 50)->nullable();
            $table->integer('trade_name', false, true)->length(10)->unsigned()->nullable();
            $table->string('mall', 100)->nullable();
            $table->string('branch', 50)->nullable();
            $table->string('bill_to', 50)->nullable();
            $table->string('tin_no', 50)->nullable();
            $table->integer('tax_country_id', false, true)->length(10)->unsigned()->nullable();
            $table->text('ship_to_address');
            $table->string('building_no', 50)->nullable();
            $table->string('lot_blk_no_streetname', 50)->nullable();
            $table->string('barangay', 50)->nullable();
            $table->integer('city_id', false, true)->length(10)->unsigned()->nullable();
            $table->integer('state_id', false, true)->length(10)->unsigned()->nullable();
            $table->string('area_code_zip_code', 50)->nullable();
            $table->integer('country_id', false, true)->length(10)->unsigned()->nullable();
            $table->string('contact_person', 100)->nullable();
            $table->string('contact_person_ln', 50)->nullable();
            $table->string('contact_person_fn', 50)->nullable();
            $table->integer('contact_designation_id', false, true)->length(10)->unsigned()->nullable();
            $table->integer('contact_department_id', false, true)->length(10)->unsigned()->nullable();
            $table->string('account_person', 100)->nullable();
            $table->string('account_person_ln', 50)->nullable();
            $table->string('account_person_fn', 50)->nullable();
            $table->integer('account_designation_id', false, true)->length(10)->unsigned()->nullable();
            $table->integer('account_department_id', false, true)->length(10)->unsigned()->nullable();
            $table->string('landline_no', 30)->nullable();
            $table->string('international_country_code_1', 50)->nullable();
            $table->string('area_code_1', 30)->nullable();
            $table->string('number_1', 30)->nullable();
            $table->string('mobile_number', 20)->nullable();
            $table->string('international_country_code_2', 50)->nullable();
            $table->string('area_code_2', 30)->nullable();
            $table->string('number_2', 30)->nullable();
            $table->string('email_address', 50)->nullable();
            $table->string('beneficiary_name', 50)->nullable();
            $table->string('account_number', 50)->nullable();
            $table->text('beneficiary_address');
            $table->string('bank_beneficiary', 50)->nullable();
            $table->text('bank_address');
            $table->string('bank_code', 30)->nullable();
            $table->string('switf_code', 30)->nullable();
            $table->string('bic', 30)->nullable();
            $table->string('iban', 30)->nullable();
            $table->string('aba', 30)->nullable();
            $table->integer('currency_id', false, true)->length(10)->unsigned()->nullable();
            $table->string('credit_limit', 30)->nullable();
            $table->integer('payment_terms_id', false, true)->length(10)->unsigned()->nullable();
            $table->integer('payment_mode_id', false, true)->length(10)->unsigned()->nullable();
            $table->string('bea_pricelist', 50)->nullable();
            $table->string('pos_name', 50)->nullable();
            $table->string('ref',15)->nullable();
            $table->integer('status_id', false, true)->length(10)->unsigned()->nullable();
            $table->date('status_as_date');
            $table->integer('approved_by_1', false, true)->length(10)->unsigned()->nullable();
            $table->dateTime('approved_at_1');	
            $table->dateTime('disapproved_at_1');	
            $table->integer('approved_by_2', false, true)->length(10)->unsigned()->nullable();
            $table->dateTime('approved_at_2');	
            $table->dateTime('disapproved_at_2');	
            $table->integer('created_by', false, true)->length(10)->unsigned()->nullable();
            $table->integer('updated_by', false, true)->length(10)->unsigned()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_temp');
    }
}
