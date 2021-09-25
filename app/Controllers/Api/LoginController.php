<?php
/**
 * User: nano
 * Datetime: 2021/9/25 5:23 下午
 */

namespace App\Controllers\Api;


class LoginController
{
    public function loginCaptcha()
    {
        $phone = $_POST['phone'] ?? '';
        if(empty($phone)){
            return returnJson(400, "请输入正确的手机号码");
        }

        if (preg_match("/^1\d{10}$/")) {
            return returnJson(400, "请输入正确的手机号码");
        }

        return returnJson();
    }


}