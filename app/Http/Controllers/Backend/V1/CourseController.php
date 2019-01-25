<?php
/**
 * Created by PhpStorm.
 * User: xiatong
 * Date: 2019/1/16
 * Time: 9:37 AM
 */

namespace App\Http\Controllers\Backend\V1;


use App\Http\Controllers\ApiController;
use App\Service\CourseService;
use Illuminate\Http\Request;

class CourseController extends ApiController
{
    protected $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;

    }

    public function list(Request $request)
    {
        $limit = $request->get('limit');
        return $items = $this->courseService->BackList($limit);
    }

    public function info($id)
    {
        $item = $this->courseService->BackInfo($id);
        return $this->apiReturn($item);
    }

    public function create(Request $request)
    {
        $param = $request->all();
        $res = $this->courseService->BackUpdateOreCreate($param);
        return $this->apiReturn();
    }

    public function toupiao()
    {
        $url = 'http://lovesuizhou.com/app/index.php?i=3&c=entry&vote=1&rid=568&from_user=oS6THjobXRShw1kvPEb1zJezLKtg&do=Tvotestart&m=fm_photosvote&up_voteer=1';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //TRUE 将curl_exec()获取的信息以字符串返回，而不是直接输出。

        $header = [
            'Host: lovesuizhou.com',
            'Accept: application/json, text/javascript, */*; q=0.01',
            'X-Requested-With: XMLHttpRequest',
            'Accept-Language: zh-cn',
            'Accept-Encoding: gzip, deflate',
            'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
            'Origin: http://lovesuizhou.com',
            'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 12_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/16B92 MicroMessenger/7.0.3(0x17000321) NetType/WIFI Language/zh_CN',
            'Referer: http://lovesuizhou.com/app/index.php?i=3&c=entry&rid=568&fromuser=oS6THjnu9-RFGMmaLVB3tOKhNhwI&tfrom_user=oS6THjldbZgXxNi41QOiwvC7ctBM&do=tuser&m=fm_photosvote',
            'Content-Length: 66',
            'Cookie: user_oauth2_openid=oS6THjobXRShw1kvPEb1zJezLKtg; user_yuedu=oS6THjobXRShw1kvPEb1zJezLKtg5683; user_yuedua=oS6THjobXRShw1kvPEb1zJezLKtg5683; user_tbsj_time=1548322085; user_fromuser_openid=oS6THjnu9-RFGMmaLVB3tOKhNhwI; user_tfrom_user_openid=oS6THjldbZgXxNi41QOiwvC7ctBM; PHPSESSID=78cc6a97dbc0a5d64151f6385403ad85',
            'Connection: keep-alive'
        ]; //设置一个你的浏览器agent的header
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        curl_setopt($ch, CURLOPT_HEADER, 1); //返回response头部信息
        curl_setopt($ch, CURLINFO_HEADER_OUT, true); //TRUE 时追踪句柄的请求字符串，从 PHP 5.1.3 开始可用。这个很关键，就是允许你查看请求header

        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);

        echo curl_getinfo($ch, CURLINFO_HEADER_OUT); //官方文档描述是“发送请求的字符串”，其实就是请求的header。这个就是直接查看请求header，因为上面允许查看

        curl_close($ch);

        return $result;
    }
}