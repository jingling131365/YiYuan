<?php
// +----------------------------------------------------------------------
// | Date: 2024-09-04
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
namespace app\common\library\sms;

/**
 * Sms 驱动抽象类
 */
abstract class Driver
{

    /**
     * 服务
     * @var object|null
     */
    protected object|null $service = null;

    /**
     * 获取服务
     */
    abstract protected function getService();

    /**
     * 发送验证码
     * @param $sendNo
     * @return bool|string
     */
    abstract public function sendCode($sendNo): bool|string;


    /**
     * 验证验证码
     * @param $sendNo
     * @param $code
     * @return bool|string
     */
    abstract public function verify($sendNo, $code): bool|string;
}