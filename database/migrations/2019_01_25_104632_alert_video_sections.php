<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertVideoSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table('video_sections',function (Blueprint $tabel){
		    $tabel->addColumn('smallInteger','section_num')->unsigned()->default(0)->comment('音频节数');
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
