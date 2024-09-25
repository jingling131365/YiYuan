<?php
// +----------------------------------------------------------------------
// | Date: 2024-09-02
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
namespace app\common\model\user;

use app\common\model\BaseModel;

/**
 * 用户分组模型
 */
class UserGroupModel extends BaseModel
{
    protected $name = 'user_group';

    public function getRulesAttr($value): array
    {
        if($value == '*') {
            return (new UserRuleModel())->where('status',1)->column('id');
        }else {
            return array_map('intval',explode(',',$value));
        }
    }

}