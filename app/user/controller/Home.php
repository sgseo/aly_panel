<?php
/**
 * Created by kutori.
 * OSUser: Administrator
 * Date: 2018\5\9 0009
 * Time: 12:11
 */

namespace app\user\controller;

use think\Controller;
use app\common\model\Bind;
use app\common\controller\Ecs;
use think\Request;
use think\Session;

class Home extends Controller
{
    public function _initialize()
    {
        $request = Request::instance();

        if (Session::get('uid') == null) {
            $ret['code'] = '0';
            $ret['msg'] = '请先登录！';
            exit(json_encode($ret));
        }

        $list = ['stopecs', 'startecs', 'rebootecs', 'updatepassword'];

        if (in_array($request->action(), $list)) {
            $uid = $request->param('uid');
            $regionid = $request->param('regionid');
            $instanceid = $request->param('instanceid');
            if ($uid == null || $regionid == null || $instanceid == null) {
                $ret['code'] = '0';
                $ret['msg'] = '参数不能为空！';
                exit(json_encode($ret));
            } else {
                if(Session::get('uid')!=$uid){
                    $ret['code'] = '0';
                    $ret['msg'] = '没有操作权限！';
                    exit(json_encode($ret));
                }else{
                    $bind = new Bind();
                    $result = $bind->where('uid', $uid)
                        ->where('regionid', $regionid)
                        ->where('instanceid', $instanceid)
                        ->find();
                    if ($result == null) {
                        $ret['code'] = '0';
                        $ret['msg'] = '没有操作权限！';
                        exit(json_encode($ret));
                    }
                }
            }
        }
    }

    public function allEcs($uid = '')
    {
        if ($uid == null) {
            $ret['code'] = '0';
            $ret['msg'] = '参数不能为空！';
        } else {
            $bind = new Bind();
            $result = $bind->where('uid', $uid)->select();
            $ret['code'] = '1';
            $list = array();
            foreach ($result as $value) {
                $ecs = new Ecs();
                $res = $ecs->getEcsInfo($value['regionid'], $value['instanceid']);
                array_push($list, $res);
            }
            $ret['data'] = $list;
        }
        return json($ret);
    }

    public function stopEcs($uid, $regionid, $instanceid)
    {
        $ecs = new Ecs();
        $res = $ecs->stopEcs($regionid, $instanceid);
        $ret['code'] = '1';
        return json($ret);
    }

    public function startEcs($uid, $regionid, $instanceid)
    {
        $ecs = new Ecs();
        $res = $ecs->startEcs($regionid, $instanceid);
        $ret['code'] = '1';
        return json($ret);
    }

    public function rebootEcs($uid, $regionid, $instanceid)
    {
        $ecs = new Ecs();
        $res = $ecs->rebootEcs($regionid, $instanceid);
        $ret['code'] = '1';
        return json($ret);
    }

    public function updatePassword($uid, $regionid, $instanceid, $password='')
    {
        if ($password == null) {
            $ret['code'] = '0';
            $ret['msg'] = '参数不能为空！';
        } else {
            $ecs = new Ecs();
            $res = $ecs->updatePassword($regionid, $instanceid, $password);
            $ret['data'] = $res;
            $ret['code'] = '1';
        }
        return json($ret);

    }
}