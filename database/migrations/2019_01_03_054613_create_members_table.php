<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('phone')->nullable(false);
            $table->char('password',64)->nullable(false);
            $table->string('avatar',200)->default('');
            $table->string('nickname',100)->default('');
            $table->unsignedTinyInteger('identify')->default(0)->comment('身份 1.患者 2.家属 3.医疗从业者 4.非医疗从业者');
            $table->date('birth')->default(null)->comment('生日');
            $table->date('diagnosis_at')->default(null)->comment('首次确诊时间');
            $table->unsignedInteger('province_id')->default(0)->comment('省份id');
            $table->unsignedInteger('city_id')->default(0)->comment('城市id');
            $table->unsignedTinyInteger('gender')->default(0)->comment('性别 0.未知 1.男 2.女');
            $table->string('company',200)->default('')->comment('公司');
	        $table->tinyInteger('enable')->default(1)->comment('状态 0.禁用 1.启用');
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
        Schema::dropIfExists('members');
    }
}
