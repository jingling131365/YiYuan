<?php
// +----------------------------------------------------------------------
// | 文件: User.php
// +----------------------------------------------------------------------
// | 功能: 提供user api接口
// +----------------------------------------------------------------------
// | 时间: 2024-09-25
// +----------------------------------------------------------------------
// | 作者: chengnn
// +----------------------------------------------------------------------

namespace app\controller;

use app\BaseController;
use Error;
use Exception;
use app\model\Counters;
use think\response\Html;
use think\response\Json;
use think\facade\Log;

class User extends BaseController
{
    /**
     * 获取openid接口
     * @return json
     */
    #[Method('GET')]
    public function getOpenId($code): Json {
        $appid = 'wx6da454ead77265df';
        $appsecret = 'e9fe96d2f4330e5b4eae52100d4a2b5e';
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid={$appid}&secret={$appsecret}&js_code={$code}&grant_type=authorization_code";
        
        $result = file_get_contents($url);
        $json = json_decode($result, true);
        if (isset($json['openid'])) {
            return $this->success('获取成功', $json);
        } else {
            return $this->error('获取失败', $json);
        }
    }
    
    /**
     * 登录接口
     * @return json
     */         
    public function login(): Json {
        $data = $this->request->param();
        $openid = $data['openid'];        
        $password = $data['password'];        
        $user = User::where('openid', $openid)->find();
        if ($user) {
            if ($user['password'] == $password) {
                return json(['code' => 0,'msg' => '登录成功', 'data' => $user]);
            } else {                
                return json(['code' => 1,'msg' => '密码错误']);
            }
        } else {
            return json(['code' => 2,'msg' => '用户不存在']);
        }
    }
    
    /**
     * 退出接口
     * @return json
     */
    public function logout(): Json {
        $data = $this->request->param();
        $openid = $data['openid'];
        $user = User::where('openid', $openid)->find();
        if ($user) {
            $user->delete();
            return json(['code' => 0,'msg' => '退出成功']);
        } else {
            return json(['code' => 1,'msg' => '用户不存在']);
        }
    }
                                                              
}
