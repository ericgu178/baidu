<?php
namespace Baidu\Common;

/**
 * 注册器
 *
 * @author EricGU178
 */
class Register
{
    /**
     * 容器
     *
     * @var array
     * @author EricGU178
     */
    protected $providers = [];

    /**
     * 配置文件
     *
     * @var array
     * @author EricGU178
     */
    protected $config = [];


    /**
     * 初始化
     *
     * @author EricGU178
     */
    public function __construct($config)
    {
        if (empty($config)) {
            throw new \Exception("百度配置文件出错");
        }
        $this->config = $config;
    }

    public function register($marker,$config=[])
    {
        if (!isset($this->providers[$marker])) {
            throw new \Exception('未定义这种方案');
        }
        if (class_exists($this->providers[$marker])) {
            return new $this->providers[$marker]($config);
        } else {
            throw new \Exception("暂时没有这个类");
        }
    }

    /**
     * 获取未定义的变量内容
     *
     * @param string $name
     * @return void
     * @author EricGU178
     */
    public function __get($name) 
    {
        $marker = self::title($name);
        return $this->register($marker,$this->config);
    }
    
    /**
     * 转换字符
     *
     * @param string $value
     * @return void
     * @author EricGU178
     */
    static private function title($value)
    {
        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        $name = str_replace(" ",'', $value);
        return $name;
    }
}