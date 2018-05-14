<?php
/**
 * Created by kutori.
 * OSUser: Administrator
 * Date: 2018\5\4 0004
 * Time: 3:14
 */

namespace app\user\controller;

use app\user\model\User;
use think\Controller;
use think\Request;
use think\Session;

class Index extends Controller
{

    public function login(Request $request)
    {
        $ret = array();
        $user = new User();
        $fusername = $user->where('username', $request->param('username'))
            ->where('password', md5($request->param('password')))
            ->find();
        $femail = $user->where('email', $request->param('username'))
            ->where('password', md5($request->param('password')))
            ->find();
        if ($fusername != null) {
            if ($fusername['isadmin'] == 1) {
                $ret['admin'] = '1';
                Session::set('admin', '1');
            }
            $ret['code'] = '1';
            Session::set('uid', $fusername['id']);
        } elseif ($femail != null) {
            if ($femail['isadmin'] == 1) {
                $ret['admin'] = '1';
                Session::set('admin', '1');
            }
            $ret['code'] = '1';
            Session::set('uid', $femail['id']);
        } else {
            Session::clear();
            $ret['code'] = '0';
            $ret['msg'] = '登录失败，请检查账户或密码！';
        }
        return json($ret);
    }

    public function loginOut()
    {
        Session::clear();
        $ret['code'] = '1';
        return json($ret);
    }

    public function register($username = '', $password = '', $email = '', $qq = '')
    {
        $data = [
            'username' => $username,
            'password' => $password,
            'email' => $email,
            'qq' => $qq,
        ];
        $result = $this->validate($data, 'Index');
        if (true !== $result) {
            $ret['code'] = '0';
            $ret['msg'] = $result;
        } else {
            if (User::get(['username' => $username]) != null) {
                $ret['code'] = '0';
                $ret['msg'] = '用户名已被注册，请更换用户名！';
            } elseif (User::get(['email' => $email]) != null) {
                $ret['code'] = '0';
                $ret['msg'] = '邮箱已被注册，请更换邮箱！';
            } else {
                $usersave = new User();
                $usersave->username = $username;
                $usersave->password = md5($password);
                $usersave->email = $email;
                $usersave->qq = $qq;
                if ($usersave->save()) {
                    $ret['code'] = '1';
                } else {
                    $ret['code'] = '0';
                    $ret['msg'] = '信息保存失败，请联系网站管理员！';
                }
            }
        }
        return json($ret);
    }


}