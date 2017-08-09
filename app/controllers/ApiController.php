<?php
/**
 * Created by PhpStorm.
 * User: ttt
 * Date: 2017/8/9
 * Time: 13:44
 */

namespace app\controllers;


class ApiController
{
    public function index($a){
        var_dump($a);
        return [
            'ret'=>200,
            'msg'=>'ok'
        ];
    }
}