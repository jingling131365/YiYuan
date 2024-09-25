<?php
/// +----------------------------------------------------------------------
// | Date: 2024-09-02
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
namespace app\common\model;

use app\common\enum\ApiEnum\ShowType as ShopTypeEnum;
use app\common\enum\ApiEnum\StatusCode;
use app\common\traits\RequestJson;
use think\Model;


/**
 * 基础模型
 */
class BaseModel extends Model
{
    use RequestJson;

    /**
     * 错误信息
     */
    private string $errorMsg = '';

    public function getErrorMsg(): string
    {
        return $this->errorMsg;
    }

    public function setErrorMsg($str = '')
    {
        return $this->errorMsg = $str;
    }

    public static function onBeforeWrite(Model $model): void
    {
        if (env('WEB_NAME') && env('WEB_NAME') == 'rasamasa_test') {
            self::renderThrow(false, [], StatusCode::WARN->value, '演示站已禁止此操作', ShopTypeEnum::WARN_MESSAGE->value);
        }
    }

    public static function onBeforeDelete(Model $model): void
    {
        if (env('WEB_NAME') && env('WEB_NAME') == 'rasamasa_test') {
            self::renderThrow(false, [], StatusCode::WARN->value, '演示站已禁止此操作', ShopTypeEnum::WARN_MESSAGE->value);
        }
    }

    /**
     * 新增前
     * @param Model $model
     * @return void
     */
    public static function onBeforeInsert(Model $model): void
    {

    }

    /**
     * 新增后
     * @param Model $model
     * @return void
     */
    public static function onAfterInsert(Model $model): void
    {

    }

    /**
     * 字段值增长
     * @param int|bool|array $where
     * @param string $field
     * @param float $step
     * @return bool
     */
    protected function setInc(int|bool|array $where, string $field, float $step = 1): bool
    {
        if (is_numeric($where)) {
            $where = [$this->getPk() => (int)$where];
        }
        return $this->where($where)->inc($field, $step)->save();
    }

    /**
     * 字段值消减
     * @param int|bool|array $where
     * @param string $field
     * @param float $step
     * @return bool
     */
    protected function setDec(int|bool|array $where, string $field, float $step = 1): bool
    {
        if (is_numeric($where)) {
            $where = [$this->getPk() => (int)$where];
        }
        return $this->where($where)->dec($field, $step)->save();
    }

    /**
     * 查找单条记录
     * @param mixed $data 查询条件
     * @param array $with 关联查询
     * @return array|static|null
     */
    public static function get(mixed $data, array $with = []): array|static|null
    {
        try {
            $query = (new static)->with($with);
            return is_array($data) ? $query->where($data)->find() : $query->find((int)$data);
        } catch (\Exception $e) {
            return null;
        }
    }


}