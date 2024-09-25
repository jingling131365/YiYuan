<?php
// +----------------------------------------------------------------------
// | Date: 2024-09-09
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
namespace app\common\model\area;

use app\common\model\BaseModel;

/**
 * 用户模型
 */
class AreaModel extends BaseModel
{
    protected $name = 'area';

    protected $hidden = [
        'create_time', 'update_time'
    ];

    /**
     * area
     * @return  array 
     */
    public function getAreas()
    {
        $detail = $this->select()->toArray();
        return $detail;
    }

}