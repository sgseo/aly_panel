<?php
/**
 * Created by kutori.
 * OSUser: Administrator
 * Date: 2018\5\7 0007
 * Time: 14:24
 */

namespace app\admin\controller;

use app\common\model\Bind;
use app\common\model\Config;
use app\common\controller\Ecs;
use think\Controller;
use think\Session;

class Home extends Controller
{
    public function _initialize()
    {
        if (Session::get('admin') != '1') {
            $ret['code'] = '0';
            $ret['msg'] = '没有操作权限！';
            exit(json_encode($ret));
        }
    }

    public function allEcs($regionid = 'cn-hangzhou')
    {
        $ecs = new Ecs();
        $res = $ecs->getEcsInfo($regionid);
        $ret['code'] = '1';
        $ret['data'] = $res;
        return json($ret);
    }

    public function bind($uid = '', $instanceid = '', $regionid = '')
    {
        if ($uid == '' || $instanceid == '' || $regionid == '') {
            $ret['code'] = '0';
            $ret['msg'] = '参数不能为空！';
        } else {
            $bind = new Bind();
            $result = $bind->where('uid', $uid)
                ->where('instanceid', $instanceid)
                ->find();
            if ($result != null) {
                $ret['code'] = '0';
                $ret['msg'] = '实例已被分配给其他用户！';
            } else {
                $bind->uid = $uid;
                $bind->instanceid = $instanceid;
                $bind->regionid = $regionid;
                if ($bind->save()) {
                    $ret['code'] = '1';
                } else {
                    $ret['code'] = '0';
                    $ret['msg'] = '操作失败！';
                }
            }
        }
        return json($ret);
    }

    public function unbind($uid = '', $instanceid = '')
    {
        if ($uid == '' || $instanceid == '') {
            $ret['code'] = '0';
            $ret['msg'] = '参数不能为空！';
        } else {
            $bind = new Bind();
            $result = $bind->where('uid', $uid)
                ->where('instanceid', $instanceid)
                ->delete();
            if ($result) {
                $ret['code'] = '1';
            } else {
                $ret['code'] = '0';
                $ret['msg'] = '操作失败！';
            }
        }
        return json($ret);
    }

    public function updataConfig()
    {
    }
}