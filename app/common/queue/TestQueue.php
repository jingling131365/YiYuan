<?php
// +----------------------------------------------------------------------
// | Date: 2024-09-18
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
// | File: TeseQueue.php 
// +----------------------------------------------------------------------
// | Description: 消息队列消费者
// +---------------------------------------------------------------------- 
namespace app\common\queue;

use think\Log;
use think\queue\Job;

class TestQueue
{
    // 消费者执行入口
    public function fire(Job $job, $data)
    {
        // 具体执行业务
        $isJobDone = $this->doJob($data);
        
        if ($isJobDone) {
            // 消息队列执行成功，删除队列，否则会一直执行
            $job->delete();
        } else {
            // 消息队列执行失败
            // 获取消息队列已经重试了几遍
            $attempts = $job->attempts();
            if ($attempts == 0 || $attempts == 1) {
                // 重新发布，参数 delay 是延时发布的时间
                $job->release(2);
            }
        }
    }

    // 消息队列执行失败后会自动执行该方法
    public function failed($data)
    {
        Log::error('消息队列达到最大重复执行次数后失败：' . json_encode($data));
    }

    // 消息队列执行方法
    public function doJob($data)
    {
        // 具体执行业务
        
        
        $data = json_encode($data);
        echo '消息队列：' . $data;
        // 这里的判断条件以具体业务是否执行成功进行判断
        if ($data) {
            echo "执行成功";
            return true;
        } else {
            echo "执行失败";
            return false;
        }
    }
}
