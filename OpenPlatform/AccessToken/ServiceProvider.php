<?php
namespace Baidu\OpenPlatform\AccessToken;

use \Baidu\Common\Request;

/**
 * Ocr
 *
 * @author EricGU178
 */
class ServiceProvider extends Request
{
    /**
     * 获取百度accessToken
     *
     * @return void
     * @author EricGU178
     */
    public function getAccessToken()
    {
        $fp = fopen("accesstoken.txt","r");//只读方式
        $content = fread($fp,4096*2);
        fclose($fp);
        if (!empty($content)) {
            $content = json_decode($content,true);
            // 过期
            if ($content['expires_in'] + $content['create_time'] < time()) {
                goto end;
            }
            return $content['access_token'];
        }
        end:
        $url = 'https://aip.baidubce.com/oauth/2.0/token';
        $request_data = [
            'grant_type'        =>  'client_credentials',
            'client_id'         =>  $this->api_key,
            'client_secret'     =>  $this->secret_key
        ];
        $response = $this->execute($url,$request_data);
        $response['create_time'] = time();
        $fp = fopen("accesstoken.txt","w");
        fwrite($fp,json_encode($response,256));
        fclose($fp);
        return $response['access_token'];
    }
}