<?php
// +----------------------------------------------------------------------
// | Date: 2024-09-04
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
namespace app\common\model\file;

use app\common\model\BaseModel;

/**
 * 文件分组模型
 */
class FileGroupModel extends BaseModel
{
    protected $name = 'file_group';

    protected $pk = 'group_id';

    /**
     * 分组详情
     * @param array|int $where
     * @return static|array|null
     */
    public static function detail(array|int $where): array|static|null
    {
        return self::get($where);
    }
}