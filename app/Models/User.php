<?php

namespace App\Models;

use Moon\Db\Table;


/**
 * Class App\Models\User
 * @property integer $id
 * @property string $username 用户名
 * @property string $phone 手机号
 * @property string $avatar 头像
 * @property string $token 登录token
 * @property integer $status 0正常 -1删除
 * @property string $created_at
 * @property string $updated_at
 */
class User extends Table
{
    protected $primaryKey = 'id';

    public static function tableName()
    {
        return '{{user}}';
    }

    /**
     * @return \Moon\Db\Connection
     */
    public static function getDb()
    {
        return \App::$container->get('db');
    }

    public static function create(array $params)
    {
        $model = new static();
        $model->setAttributes($params);
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $res = $model->save();
        if (!$res) {
            return false;
        }
        return $model;
    }

    public static function getUserByPhone($phone)
    {
        return static::find()->where("phone=? and status=0", [$phone])->first();
    }

    public static function getUserByToken($token)
    {
        return static::find()->where("token=? and status=0", [$token])->first();
    }


}