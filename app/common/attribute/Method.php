<?php
// +----------------------------------------------------------------------
// | Date: 2024-09-04
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
// | File: Method.php
// +----------------------------------------------------------------------         
namespace app\common\attribute;

use app\common\enum\ApiEnum\StatusCode;
use app\common\traits\RequestJson;
use Attribute;

/**
 * 请求注解类
 */
#[Attribute(\Attribute::TARGET_METHOD)]
class Method
{
    use RequestJson;

    public function __construct(string $method)
    {
        if (!$method) {
            return;
        }
        if(function_exists('request')) {
            $currentMethod = request()->method();
            if ($method == $currentMethod) {
                return;
            }
            $this->throwError('请求方式错误，请检查！');
        }
    }

}