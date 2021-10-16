<?php
/**
 * User: nano
 * Datetime: 2021/10/16 1:43 下午
 */

namespace App\Controllers\Api;


use App\Models\User;
use Moon\Pagination\Pagination;

class UserController
{
    public function index(){
        $pageNo = $_GET['pageNo'] ?? 1;
        $pageSize = $_GET['pageSize'] ?? 10;
        $name = $_GET['name'] ?? '';

        $conditon = '1=1';
        $params = [];
        if(strlen(trim($name)) > 0){
            $conditon .= ' AND `username`=?';
            $params[] = $name;
        }

        //$query = User::find()->where("1=1");
        $total = User::find()->where($conditon, $params)->count();
        $pagination = new Pagination($total, $pageSize, 2, 'pageNo');
        $list = User::find()->where($conditon, $params)
            ->limit($pagination->getLimit())->offset($pagination->getOffset())
            ->order('id desc')
            ->all();
        return returnJson(0, "success", [
            'total'=>$total,
            'list' => $list
        ]);
    }
}