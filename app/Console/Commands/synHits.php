<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\Video;
use Illuminate\Console\Command;
use Redis;

class synHits extends Command
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
       $articleData = Redis::hgetall(config('rediskeys.articleHits'));
       collect($articleData)->each(function ($val, $key){
       	Article::whereId($key)->update(['hits'=>$val]);
       });

       //视频
       $courseData = Redis::hgetall(config('rediskeys.courseHits'));
       collect($courseData)->each(function ($val, $key){
       	Course::whereId($key)->update(['hits'=>$val]);
       });

       //音频
       $videoData = Redis::hgetall(config('rediskeys.videoHits'));
       collect($videoData)->each(function ($val, $key){
       	Video::whereId($key)->update(['hits'=>$val]);
       });
    }
}
