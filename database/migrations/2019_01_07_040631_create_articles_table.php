<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
	        $table->unsignedInteger('hits')->comment('点击量');
            $table->string('title',200)->default('')->nullable(false);
            $table->unsignedInteger('disease_id')->default(0)->nullable(false)->comment('病种');
            $table->unsignedInteger('doctor_id')->default(0)->nullable(false)->comment('作者');
            $table->string('image')->default('')->nullable(false)->comment('封面');
	        $table->text('content')->default(null)->comment('内容');
	        $table->float('sort', 5 ,2)->default(0)->unsigned()->comment('排序');
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
        Schema::dropIfExists('articles');
    }
}
