<?php

namespace App\Commands;


use App\Models\ShortUrl;

class ShortUrlCommand
{
    public function create($origin_url)
    {
        $model = new ShortUrl();
        $model->origin_url = $origin_url;
        $model->url = substr(md5($model->origin_url), 0, 6);
        $model->create_time = date('Y-m-d H:i:s');
        $res = $model->save();
        var_dump($res);
        return 0;
    }

    public function getList()
    {
        $list = ShortUrl::find()->order('id desc')->all();
        foreach ($list as $item) {
            echo sprintf("%5d\t%s\t%s\t%s\n", $item->id, env('APP_URL').'/'.$item->url,
                $item->origin_url, $item->create_time);
        }
        return 0;
    }
}