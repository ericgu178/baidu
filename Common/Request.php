<?php
namespace Baidu\Common;
use \Baidu\Tools\Request as tool;
use \Baidu\OpenPlatform\AccessToken\ServiceProvider as token;

class Request
{
    protected $config = [];

    protected $api_key = null;

    protected $secret_key = null;
    
    public function __construct($config)
    {
        $this->config = $config;
        $this->api_key = $this->config['api_key'];
        $this->secret_key = $this->config['secret_key'];
    }

    /**
     * 执行
     *
     * @return void
     * @author EricGU178
     */
    public function execute($url,$request_data = [])
    {
        if (empty($request_data)) {
            $response = tool::curl_get_https($url);
        }
        $response = tool::curl_post_https($url,$request_data);
        return json_decode($response,true);
    }

    /**
     * 获取access_token
     *
     * @return void
     * @author EricGU178
     */
    protected function getAccessToken()
    {
        $token = new token($this->config);
        return $token->getAccessToken();
    }
}