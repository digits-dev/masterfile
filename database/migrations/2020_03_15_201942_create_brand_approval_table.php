<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBrandApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brand_approval', function (Blueprint $table) {
            $table->increments('id');
            $table->string('action_type',10)->nullable();
            $table->tinyInteger('approval_status_id', false, true)->length(3)->unsigned()->nullable();
            $table->tinyInteger('system_id', false, true)->length(3)->unsigned()->nullable();
            $table->string('brand_ref',5)->nullable();
            $table->unique('brand_ref', 'brand_ref');
            $table->string('brand_code',5)->nullable();
            $table->unique('brand_code', 'brand_code');
            $table->string('brand_description',30)->nullable();
            $table->unique('brand_description', 'brand_description');
            $table->string('brand_beacode',10)->nullable();
            $table->integer('brand_type_id',10)->nullable();
            $table->integer('incoterms_id',10)->nullable();
            $table->enum('brand_status',['ACTIVE','INACTIVE'])->nullable();
            $table->tinyInteger('encoder_privilege_id', false, true)->length(3)->unsigned()->nullable();
            $table->integer('approved_by_1', false, true)->length(10)->unsigned()->nullable();
            $table->dateTime('approved_at_1');	
            $table->dateTime('disapproved_at_1');	
            $table->integer('approved_by_2', false, true)->length(10)->unsigned()->nullable();
            $table->dateTime('approved_at_2');	
            $table->dateTime('disapproved_at_2');	
            $table->tinyInteger('created_by',false,true)->length(3)->nullable();
            $table->tinyInteger('updated_by',false,true)->length(3)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('brand_approval');
    }
}
