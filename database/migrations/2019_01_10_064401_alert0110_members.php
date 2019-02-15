<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Alert0110Members extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('members', function (Blueprint $table){
        	$table->date('birth')->nullable()->default(null)->change();
        	$table->date('diagnosis_at')->nullable()->default(null)->change();
        	$table->addColumn('integer','inventor')->default(0)->comment('邀请人id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
