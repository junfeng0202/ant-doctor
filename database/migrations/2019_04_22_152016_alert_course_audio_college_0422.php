<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertCourseAudioCollege0422 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	// 课程售价
	    Schema::table('courses',function (Blueprint $tabel){
		    $tabel->addColumn('smallInteger','price')->unsigned()->default(0)->comment('售价');
		    $tabel->addColumn('smallInteger','active_price')->unsigned()->default(0)->comment('活动价');
		    $tabel->addColumn('tinyInteger','active_on')->unsigned()->default(0)->comment('是否开启活动');
		    $tabel->addColumn('timestamp','active_start_at')->default(null)->nullable()->comment('活动开始时间');
		    $tabel->addColumn('timestamp','active_end_at')->default(null)->nullable()->comment('活动结束时间');
	    });

	    //课程章节试看
	    Schema::table('course_sections',function (Blueprint $tabel) {
		    $tabel->addColumn('tinyInteger', 'is_free')->unsigned()->default(0)->comment('开启试看');
	    });

	    //音频售价
	    Schema::table('videos',function (Blueprint $tabel){
		    $tabel->addColumn('smallInteger','price')->unsigned()->default(0)->comment('售价');
		    $tabel->addColumn('smallInteger','active_price')->unsigned()->default(0)->comment('活动价');
		    $tabel->addColumn('tinyInteger','active_on')->unsigned()->default(0)->comment('是否开启活动');
		    $tabel->addColumn('timestamp','active_start_at')->default(null)->nullable()->comment('活动开始时间');
		    $tabel->addColumn('timestamp','active_end_at')->default(null)->nullable()->comment('活动结束时间');
	    });

	    //音频试听
	    Schema::table('video_sections',function (Blueprint $tabel) {
		    $tabel->addColumn('tinyInteger', 'is_free')->unsigned()->default(0)->comment('开启试看');
	    });

	    //讲堂售价
	    Schema::table('colleges',function (Blueprint $tabel) {
		    $tabel->addColumn('tinyInteger','sold_on')->unsigned()->default(0)->comment('是否销售学习卡');
		    $tabel->addColumn('smallInteger','price')->unsigned()->default(0)->comment('售价');
		    $tabel->addColumn('smallInteger','active_price')->unsigned()->default(0)->comment('活动价');
		    $tabel->addColumn('tinyInteger','active_on')->unsigned()->default(0)->comment('是否开启活动');
		    $tabel->addColumn('timestamp','active_start_at')->default(null)->nullable()->comment('活动开始时间');
		    $tabel->addColumn('timestamp','active_end_at')->default(null)->nullable()->comment('活动结束时间');
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
