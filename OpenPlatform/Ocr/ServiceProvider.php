<?php
namespace Baidu\OpenPlatform\Ocr;

use \Baidu\Common\Request;
use \Baidu\Tools\Tool;
/**
 * Ocr
 *
 * @author EricGU178
 */
class ServiceProvider extends Request
{

    /**
     * 网络图片文字识别 根据图像路径
     *
     * 用户向服务请求识别一些网络上背景复杂，特殊字体的文字。
     * 
     * @param file_path 路径
     * @param detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:
                    - true：检测朝向；
                    - false：不检测朝向。
       @param detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
     * @return void
     * @author EricGU178
     */
    public function webImageFromImg($file_path,$detect_direction = false,$detect_language = false)
    {
        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/webimage?access_token=' . $this->getAccessToken();
        $image = tool::imgToBase64($file_path); // 傻逼百度 不需要urlencode 神坑
        $request_data = [
            'image'             =>  $image,
            'detect_direction'  =>  $detect_direction,
            'detect_language'   =>  $detect_language
        ];
        $response = $this->execute($url,$request_data);
        return $response;
    }

    /**
     * 通用文字识别
     * 
     * 用户向服务请求识别某张图中的所有文字。
     * 
     * @param file_path 路径
     * @param detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:
                    - true：检测朝向；
                    - false：不检测朝向。
       @param detect_language 是否检测语言，默认不检测。当前支持（中文、英语、日语、韩语）
       @param language_type 识别语言类型，默认为CHN_ENG。可选值包括：
                    - CHN_ENG：中英文混合；
                    - ENG：英文；
                    - POR：葡萄牙语；
                    - FRE：法语；
                    - GER：德语；
                    - ITA：意大利语；
                    - SPA：西班牙语；
                    - RUS：俄语；
                    - JAP：日语；
                    - KOR：韩语

       @param probability 是否返回识别结果中每一行的置信度
     * @method post 
     * @return void
     * @author EricGU178
     */
    public function generalBasicFromImg
    (
        $file_path,
        $language_type='CHN_ENG',
        $detect_direction = false,
        $detect_language = false,
        $probability = false
    )
    {
        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/general_basic?access_token=' . $this->getAccessToken();
        $image = tool::imgToBase64($file_path); // 傻逼百度 不需要urlencode 神坑
        $request_data = [
            'image'             =>  $image,
            'detect_direction'  =>  $detect_direction,
            'detect_language'   =>  $detect_language,
            'probability'       =>  $probability,
            'language_type'     =>  $language_type
        ];
        $response = $this->execute($url,$request_data);
        return $response;
    }

    /**
     * 通用文字识别（高精度版）
     *
     * 用户向服务请求识别某张图中的所有文字，相对于通用文字识别该产品精度更高，但是识别耗时会稍长。
     * @param string $file_path
     * @param detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:
                    - true：检测朝向；
                    - false：不检测朝向。
     * @param probability 是否返回识别结果中每一行的置信度
     * @return void
     * @author EricGU178
     */
    public function accurateBasicFromImg($file_path,$detect_direction = false,$probability = false)
    {
        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/accurate_basic?access_token=' . $this->getAccessToken();
        $image = tool::imgToBase64($file_path); // 傻逼百度 不需要urlencode 神坑
        $request_data = [
            'image'             =>  $image,
            'detect_direction'  =>  $detect_direction,
            'probability'       =>  $probability,
        ];
        $response = $this->execute($url,$request_data);
        return $response;
    }

    /**
     * 数字识别
     *
     * 对图像中的阿拉伯数字进行识别提取，适用于快递单号、手机号、充值码提取等场景
     * 
     * @param string $file_path
     * @param detect_direction 是否检测图像朝向，默认不检测，即：false。朝向是指输入图像是正常方向、逆时针旋转90/180/270度。可选值包括:
                    - true：检测朝向；
                    - false：不检测朝向。
     * @param probability 是否返回识别结果中每一行的置信度
     * @return void
     * @author EricGU178
     */
    public function numbers($file_path,$recognize_granularity = false,$detect_direction = false)
    {
        $url = 'https://aip.baidubce.com/rest/2.0/ocr/v1/numbers?access_token=' . $this->getAccessToken();
        $image = tool::imgToBase64($file_path); // 傻逼百度 不需要urlencode 神坑
        $request_data = [
            'image'                     =>  $image,
            'detect_direction'          =>  $detect_direction,
            'recognize_granularity'     =>  $recognize_granularity,
        ];
        $response = $this->execute($url,$request_data);
        return $response;
    }
}