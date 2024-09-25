<?php
// +----------------------------------------------------------------------
// | Date: 2024-09-02
// +----------------------------------------------------------------------
// | Author: chengnn
// +----------------------------------------------------------------------
namespace app\common\library\storage;

use app\common\library\storage\driver\Driver;
use Exception;
use InvalidArgumentException;
use think\facade\Config;
use think\helper\Str;


/**
 * 储存系统
 */
class Storage
{

    // 当前存储引擎
    protected string $storage;

    // 当前存储引擎类
    public null | Driver $engine = null;

    // 驱动类命名空间
    protected string $namespace = '\\app\\common\\library\\storage\\driver\\';

    private mixed $config;  // upload 配置

    /**
     * 构造方法
     * @param string $storage 储存引擎
     */
    public function __construct(string $storage = '')
    {
        $this->storage = $storage;
     $this->config = Config::get('rasamasa.storage');
        $this->engine = $this->getDriver();
    }

    /**
     * 获取驱动句柄
     * @return mixed
     */
    public function getDriver(): mixed
    {
        if (!is_null($this->engine)) {
            return $this->engine;
        }
        $storage = empty($this->storage) ? $this->config['default'] : $this->storage;
        $class = $this->namespace . Str::studly($storage);
        if (class_exists($class)) {
            return new $class($storage, $this->config['engine'][$storage]);
        }
        throw new InvalidArgumentException("Storage Driver [$storage] not supported.");
    }

    /**
     * 设置磁盘配置
     * @param string $disk
     * @return void
     */
    public function setDisk(string $disk): void
    {
        $this->engine->setDisk($disk);
    }

    /**
     * 设置上传文件的验证规则
     * @param string $rules
     * @return void
     */
    public function setValidationScene(string $rules = ''): void
    {
        $this->engine->setValidationScene($rules);
    }

    /**
     * 设置上传的文件信息
     * @param string $name
     * @return void
     */
    public function setUploadFile(string $name): void
    {
        $this->engine->setUploadFile($name);
    }

    /**
     * 执行文件上传
     */
    public function upload(): bool
    {
        return $this->engine->upload();
    }

    /**
     * 执行文件删除
     * @param array $fileInfo
     * @return bool
     */
    public function delete(array $fileInfo): bool
    {
        return $this->engine->delete($fileInfo);
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError(): string
    {
        return $this->engine->getError();
    }

    /**
     * 返回保存的文件信息
     * @return array
     */
    public function getSaveFileInfo(): array
    {
        return $this->engine->getSaveFileInfo();
    }


}