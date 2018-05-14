<?php
/**
 * Created by kutori.
 * OSUser: Administrator
 * Date: 2018\5\14 0014
 * Time: 11:18
 */

namespace app\user\validate;

use think\Validate;

class Index extends Validate
{
    protected $rule = [
        'username' => 'require|max:12|min:6',
        'password' => 'require|max:25|min:6',
        'email' => 'require|email|max:30',
        'qq' => 'number',
    ];

    protected $message = [
        'username.require' => '用户名不能为空!',
        'username.max' => '用户名最长为12个字符！',
        'username.min' => '用户名最短为6个字符！',
        'password.require' => '密码不能为空!',
        'password.max' => '密码最长为25个字符！',
        'password.min' => '密码最短为6个字符！',
        'email.require' => '邮箱不能为空！',
        'email.max' => '邮箱最长为30个字符！',
        'email.email' => '邮箱格式错误！',
        'qq.number' => ' QQ格式错误',
    ];
}