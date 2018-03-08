<?php
namespace App\Service\Components\Wechat;

/**
 * 微信工具类
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-08
 */
class WechatUtils {

  public function getAccessToken($appid, $appsecret) {

    $url = str_replace(array('{APPID}', '{APPSECRET}'), array($appid, $appsecret), GET_ACCESS_TOKEN);

    $result = json_decode(Http::httpGet($url), true);  
  
  }

}
