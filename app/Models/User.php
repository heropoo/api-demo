<?php
namespace App\Models;

use Moon\Db\Table;

/**
 * Class App\Models\User 
 * @property integer $id 
 * @property string $username 用户名
 * @property string $email E-mail
 * @property string $password 密码
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
}