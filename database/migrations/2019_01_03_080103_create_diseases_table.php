<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiseasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diseases', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',50)->default('')->comment('名称');
            $table->unsignedInteger('pid')->default(0)->comment('父id');
            $table->float('sort',5,2)->default(0)->comment('排序');
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
        Schema::dropIfExists('diseases');
    }
}
