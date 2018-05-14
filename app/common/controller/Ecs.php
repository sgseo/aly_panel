<?php
/**
 * Created by kutori.
 * OSUser: Administrator
 * Date: 2018\5\8 0008
 * Time: 14:46
 */

namespace app\common\controller;

use app\common\model\Config;
use Ecs\Request\V20140526\DescribeInstancesRequest;
use Ecs\Request\V20140526\RebootInstanceRequest;
use Ecs\Request\V20140526\StartInstanceRequest;
use Ecs\Request\V20140526\StopInstanceRequest;
use Ecs\Request\V20140526\ModifyInstanceAttributeRequest;

require_once '..\extend\aliyun-php-sdk-core\Config.php';

class Ecs
{
    private $config;

    public function __construct()
    {
        $this->config = Config::get(0);
    }

    public function getEcsInfo($regionid, $instanceid = '')
    {
        $iClientProfile = \DefaultProfile::getProfile($regionid, $this->config['accessKeyId'], $this->config['accessSecret']);
        $iClient = new \DefaultAcsClient($iClientProfile);
        $request = new DescribeInstancesRequest();
        $request->setMethod('GET');
        if ($instanceid != '') {
            $request->setInstanceIds('["' . $instanceid . '"]');
        }
        $res = $iClient->getAcsResponse($request);
        return $res;
    }

    public function startEcs($regionid, $instanceid)
    {
        $iClientProfile = \DefaultProfile::getProfile($regionid, $this->config['accessKeyId'], $this->config['accessSecret']);
        $iClient = new \DefaultAcsClient($iClientProfile);
        $request = new StartInstanceRequest();
        $request->setInstanceId($instanceid);
        $request->setMethod("GET");
        $res = $iClient->getAcsResponse($request);
        return $res;
    }

    public function stopEcs($regionid, $instanceid)
    {
        $iClientProfile = \DefaultProfile::getProfile($regionid, $this->config['accessKeyId'], $this->config['accessSecret']);
        $iClient = new \DefaultAcsClient($iClientProfile);
        $request = new StopInstanceRequest();
        $request->setInstanceId($instanceid);
        $request->setForceStop("true");
        $request->setMethod("GET");
        $res = $iClient->getAcsResponse($request);
        return $res;
    }

    public function rebootEcs($regionid, $instanceid)
    {
        $iClientProfile = \DefaultProfile::getProfile($regionid, $this->config['accessKeyId'], $this->config['accessSecret']);
        $iClient = new \DefaultAcsClient($iClientProfile);
        $request = new RebootInstanceRequest();
        $request->setInstanceId($instanceid);
        $request->setMethod("GET");
        $res = $iClient->getAcsResponse($request);
        return $res;
    }

    public function updatePassword($regionid, $instanceid, $password)
    {
        $iClientProfile = \DefaultProfile::getProfile($regionid, $this->config['accessKeyId'], $this->config['accessSecret']);
        $iClient = new \DefaultAcsClient($iClientProfile);
        $request = new ModifyInstanceAttributeRequest();
        $request->setInstanceId($instanceid);
        $request->setPassword($password);
        $request->setMethod("GET");
        $res = $iClient->getAcsResponse($request);
        return $res;
    }

    public function replaceSystem($regionid, $instanceid, $systemid)
    {
        $iClientProfile = \DefaultProfile::getProfile($regionid, $this->config['accessKeyId'], $this->config['accessSecret']);
        $iClient = new \DefaultAcsClient($iClientProfile);
        $request = new RebootInstanceRequest();
        $request->setInstanceId($instanceid);
        $request->setImageId($systemid);
        $request->setMethod("GET");
        $res = $iClient->getAcsResponse($request);
        return $res;
    }
}