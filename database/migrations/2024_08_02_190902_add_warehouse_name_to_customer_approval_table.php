<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWarehouseNameToCustomerApprovalTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_approval', function (Blueprint $table) {
            $table->string('warehouse_name',50)->after('cutomer_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_approval', function (Blueprint $table) {
            $table->dropColumn('warehouse_name');
        });
    }
}
