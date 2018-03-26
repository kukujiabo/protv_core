<?php
namespace App\Service\Components\Wechat;

use App\Library\RedisClient;

/**
 * 微信权限服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-08
 */
class WechatAuth {

  /**
   * 获取微信接口访问令牌
   *
   * @param string appid
   * @param string appsecret
   *
   * @return
   */
  public static function getAccessToken($appid, $appsecret) {

    $accessToken = RedisClient('wechat_auth', $appid);

    if (!$accessToken || !$accessToken->access_token || $accessToken->expire_at < time()) {

      $url = str_replace(array('{APPID}', '{APPSECRET}'), array($appid, $appsecret), GET_ACCESS_TOKEN);

      $result = json_decode(Http::httpGet($url), true);  

      if ($result['errcode']) {
      
        //todo record error.
      
      } else {
      
        $newAccessToken = [
        
          'access_token' => $result['access_token'],

          'expire_at' => time() + $result['expires_in'] - 5
        
        ];

        RedisClient::set('wechat_auth', $appid, $newAccessToken);

        return $result['access_token'];
      
      }

    } else {
    
      return $accessToken['access_token'];
    
    }
  
  }

}
