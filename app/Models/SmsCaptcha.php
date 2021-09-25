<?php
/**
 * User: nano
 * Datetime: 2021/9/25 5:50 下午
 */

namespace App\Models;


use Moon\Db\Table;


/**
 * Class App\Models\SmsCaptcha
 * @property integer $id
 * @property string $type 类型
 * @property string $phone 手机号码
 * @property string $code code
 * @property integer $status 0正常 -1删除
 * @property string $created_at
 * @property string $updated_at
 */
class SmsCaptcha extends Table
{
    protected $primaryKey = 'id';

    public static function tableName()
    {
        return '{{sms_captcha}}';
    }

    /**
     * @return \Moon\Db\Connection
     */
    public static function getDb()
    {
        return \App::$container->get('db');
    }

    public static function create($type, $phone, $code)
    {
        $model = new static();
        $model->phone = $phone;
        $model->type = $type;
        $model->code = $code;
        $model->created_at = date('Y-m-d H:i:s');
        $model->updated_at = date('Y-m-d H:i:s');
        $res = $model->save();
        if(!$res){
            return false;
        }
        return $model;
    }

    public static function verifyCode($type, $phone, $code)
    {
        $model = static::find()->where("phone=:phone and type=:type and status=0",
            ['phone'=>$phone, 'type'=>$type])->order('id desc')->first();
        if (empty($model)) {
            return false;
        }
        if ($model->code === $code) {
            return true;
        }
        return false;
    }
}