<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_tbl', function (Blueprint $table) {
            $table->increments('id');
            $table->string('system_code',10)->nullable();
            $table->string('system_description',50)->nullable();
            $table->string('host',35)->nullable();
            $table->string('port',10)->nullable();
            $table->string('database_name',35)->nullable();
            $table->string('username',35)->nullable();
            $table->string('password',35)->nullable();
            $table->enum('status', array('ACTIVE', 'INACTIVE'))->default('ACTIVE')->nullable();
            $table->integer('created_by', false, true)->length(10)->unsigned()->nullable();
            $table->integer('updated_by', false, true)->length(10)->unsigned()->nullable();
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
        Schema::dropIfExists('system_tbl');
    }
}
