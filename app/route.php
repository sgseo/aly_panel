<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//使用闭包实现miss路由
Route::miss(function () {
    return '';
});

//使用路由分组
Route::group('user', [
    '/login' => 'user/index/login',
    '/loginout' => 'user/index/loginOut',
    '/register' => 'user/index/register',
    '/allecs' => 'user/home/allEcs',
    '/stopecs' => 'user/home/stopEcs',
    '/startecs' => 'user/home/startEcs',
    '/rebootecs' => 'user/home/rebootEcs',
    '/updatepassword' => 'user/home/updatePassword',
]);

Route::group('admin', [
    '/allecs' => 'admin/home/allEcs',
    '/bind' => 'admin/home/bind',
    '/unbind' => 'admin/home/unbind',
]);
