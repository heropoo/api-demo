<?php
/**
 * User: nano
 * Datetime: 2021/9/25 5:23 下午
 */

namespace App\Controllers\Api;


use App\Models\SmsCaptcha;
use App\Models\User;
use Monolog\Logger;

class LoginController
{
    public function loginCaptcha()
    {
        /** @var Logger $logger */
        $logger = \App::$container->get('logger');
        $logger->info(__METHOD__ . ':' . json_encode($_POST));
        $phone = $_POST['phone'] ?? '';
        if (empty($phone)) {
            return returnJson(400, "请输入正确的手机号码");
        }

        if (!preg_match("/^1\d{10}$/", $phone)) {
            return returnJson(400, "请输入正确的手机号码");
        }

        $code = mt_rand(100000, 999999);
        $res = SmsCaptcha::create('login', $phone, $code);
        if (!$res) {
            return returnJson(500, '发送失败');
        }
        return returnJson(0, 'success', [
            'debug' => [
                'code' => $code
            ]
        ]);
    }

    public function login()
    {
        $phone = $_POST['phone'] ?? '';
        $code = $_POST['code'] ?? '';
        if (empty($phone) || empty($code)) {
            return returnJson(400, "请输入正确的手机号码或验证码");
        }

        if (!SmsCaptcha::verifyCode('login', $phone, $code)) {
            return returnJson(400, "验证码错误");
        }

        $register = false;
        $user = User::getUserByPhone($phone);
        if (empty($user)) {
            $user = User::create(['phone' => $phone]);
            $register = true;
        }

        $token = md5(uniqid());
        $user->token = $token;
        $user->updated_at = date('Y-m-d H:i:s');
        $res = $user->save();
        if (!$res) {
            return returnJson(500, '登录失败');
        }

        return returnJson(0, "success", [
            "token" => $token,
            "is_register" => $register
        ]);
    }
}