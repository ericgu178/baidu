<?php
namespace Baidu\Tools;
/**
 * 工具类
 *
 * @author EricGU178
 */
class Request
{
    // post 请求
    static public function curl_post_https($url, $data)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        $postMultipart = false;
        $postBodyString = '';
        if(is_array($data) == true)
        {
            // Check each post field
            foreach($data as $key => &$value)
            {
                // Convert values for keys starting with '@' prefix
                if ("@" != substr($value, 0, 1)) //判断是不是文件上传
				{

					$postBodyString .= "$key=" . urlencode($value) . "&";
					// $postBodyString .= "$key=" . $value . "&";
                }

                if(strpos($value, '@') === 0)
                {
                    $postMultipart = true;
                    $filename = ltrim($value, '@');
                    $data[$key] = new \CURLFile($filename);
                }
            }
        }
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        // Post提交的数据包
        if ($postMultipart) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($curl, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $headers = array('content-type: application/x-www-form-urlencoded');
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        $res = curl_exec($curl); // 执行操作
        curl_close($curl); // 关闭CURL会话
        return $res; // 返回数据
    }

    static public function curl_get_https($url){
        $curl = curl_init();
        //设置选项，包括URL
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 1);//绕过ssl验证
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
    
        //执行并获取HTML文档内容
        $output = curl_exec($curl);
        //释放curl句柄
        curl_close($curl);
        return $output;
    }
}