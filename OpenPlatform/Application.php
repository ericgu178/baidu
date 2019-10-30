<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Baidu\OpenPlatform;
use \Baidu\Common\Register; 

class Application extends Register
{
    /**
     * 容器
     * 
     * @var array
     */
    protected $providers = [
        'Ocr'   =>  \Baidu\OpenPlatform\Ocr\ServiceProvider::class, //ocr扫描体识别
        'AccessToken' =>  \Baidu\OpenPlatform\AccessToken\ServiceProvider::class, // 鉴权认证
    ];
}
