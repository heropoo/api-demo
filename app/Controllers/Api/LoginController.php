<?php
/**
 * User: nano
 * Datetime: 2021/9/25 5:23 下午
 */

namespace App\Controllers\Api;


use App\Models\SmsCaptcha;
use Monolog\Logger;

class LoginController
{
    public function loginCaptcha()
    {
        /** @var Logger $logger */
        $logger = \App::$container->get('logger');
        $logger->info(__METHOD__.':'.json_encode($_POST));
        $phone = $_POST['phone'] ?? '';
        if (empty($phone)) {
            return returnJson(400, "请输入正确的手机号码");
        }

        if (!preg_match("/^1\d{10}$/", $phone)) {
            return returnJson(400, "请输入正确的手机号码");
        }

        $code = mt_rand(100000, 999999);
        $res = SmsCaptcha::create($phone, 'login', $code);
        if (!$res) {
            return returnJson(500, '发送失败');
        }
        return returnJson();
    }
}