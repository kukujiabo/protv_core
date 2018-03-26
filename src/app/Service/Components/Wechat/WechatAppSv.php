<?php
namespace App\Service\Components\Wechat;

use App\Service\System\ConfigSv;
use App\Library\RedisClient;

/**
 * 微信应用服务类
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-08
 */
class WechatAppSv extends ConfigSv {

  protected $_appid;

  protected $_appsecret;

  public function __construct($appName = 'straw_mini') {
  
    $this->_appid = $this->getConfig("{$appName}_appid");

    $this->_appsecret = $this->getConfig("{$appName}_appsecret");
  
  }

  /**
   * 添加应用配置
   *
   * @param string appName
   * @param string appId
   * @param string appSecret
   *
   * @return
   */
  public function editAppConf($appName, $appId, $appSecret, $title) {
  
    $res1 = $this->editConfig('wechat', 'app', "{$appName}_appid", $appId, $title);

    $res2 = $this->editConfig('wechat', 'app', "{$appName}_appsecret", $appSecret, $title);

    return $res1 || $res2;
  
  }

  /**
   * 获取微信访问令牌
   *
   * @return string accessToken
   */
  public function getAccessToken($appName = '') {
  
    return WechatAuth::getAccessToken($this->_appid, $this->_appsecret);  
  
  }


}
