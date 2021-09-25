<?php
/**
 * User: Heropoo
 * Date: 2018/1/11
 * Time: 22:11
 */

namespace App\Controllers;

use App\Models\ShortUrl;
use App\Models\User;
use Moon\HttpException;
use Moon\Request\Request;

class IndexController
{
//    protected $user;
//
//    public function __construct(User $user)
//    {
//        $this->user = $user;
//    }

    public function index(Request $request)
    {
        $view = view('index', [], 'layouts/main');
        $view->title = 'welcome';
        return $view;
    }

    public function gotoUrl($uri)
    {
        $shortUrl = ShortUrl::find()->where("url=:url", ["url" => $uri])->first();
        if (!empty($shortUrl)) {
            return redirect($shortUrl->origin_url);
        }
        throw new HttpException("Not Found", 404);
    }

    public function createUrl(Request $request)
    {
        $origin_url = trim($request->get('url'));
        if (empty($origin_url)) {
            return $this->returnJson(400, 'Please input a available url');
        }

        $app_url = env('APP_URL');

        $shortUrl = ShortUrl::find()->where("origin_url=:origin_url", ["origin_url" => $origin_url])->first();
        if (empty($shortUrl)) {
            $shortUrl = new ShortUrl();
            $shortUrl->origin_url = $origin_url;
            $shortUrl->url = substr(md5($shortUrl->origin_url), 0, 6);
            $shortUrl->create_time = date('Y-m-d H:i:s');
            $res = $shortUrl->save();
            if ($res) {
                return $this->returnJson(0, 'success', ['origin_url' => $origin_url, 'url' => $app_url.'/'.$shortUrl->url]);
            }
            return $this->returnJson(500, 'Failed to shorten this url');
        }
        return $this->returnJson(0, 'success', ['origin_url' => $origin_url, 'url' => $app_url.'/'.$shortUrl->url]);
    }

    protected function returnJson($code = 0, $msg = 'success', array $data = [])
    {
        return [
            'code' => $code,
            'msg' => $msg,
            'data' => (object)$data
        ];
    }
}