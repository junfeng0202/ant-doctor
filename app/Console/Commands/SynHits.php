<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Video;
use App\Models\VideoSection;
use Illuminate\Console\Command;
use Redis;

class SynHits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hit:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'sync hit number from cache to mysql';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
    	//文章
       $articleData = Redis::hgetall(config('redisKeys.articleHits'));
       collect($articleData)->each(function ($val, $key){
       	Article::whereId($key)->update(['hits'=>$val]);
       });

       //视频
       $courseData = Redis::hgetall(config('redisKeys.courseHits'));
       collect($courseData)->each(function ($val, $key){
       	Course::whereId($key)->update(['hits'=>$val]);
       });

       //音频
       $videoData = Redis::hgetall(config('redisKeys.videoHits'));
       collect($videoData)->each(function ($val, $key){
       	Video::whereId($key)->update(['hits'=>$val]);
       });

       //音频章节
       $videoSectionData = Redis::hgetall(config('redisKeys.videoSectionHits'));
       collect($videoSectionData)->each(function ($val, $key){
       	VideoSection::whereId($key)->update(['hits'=>$val]);
       });
    }
}
