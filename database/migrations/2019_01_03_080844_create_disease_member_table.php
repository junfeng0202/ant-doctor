<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiseaseMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disease_member', function (Blueprint $table) {
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('disease_id');
            $table->unsignedInteger('type')->default(0)->comment('类型 0.感兴趣的 1.合并症 2.并发症');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disease_member');
    }
}
