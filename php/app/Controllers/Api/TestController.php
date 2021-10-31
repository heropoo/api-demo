<?php
/**
 * User: nano
 * Datetime: 2021/10/31 4:04 下午
 */

namespace App\Controllers\Api;


class TestController
{
    public function iconList()
    {
        $url = env('APP_URL');

        $icon_list = [];
        for ($i = 1; $i <= 8; $i++) {
            $icon_list[] = [
                'id' => $i,
                'icon_url' => $url . '/img/' . $i . '.png',
            ];
        }

        return [
            'code' => 0,
            'message' => 'success',
            'data'=>['icon_list' => $icon_list]
        ];
    }
}