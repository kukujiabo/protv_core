<?php
namespace App\Service\Components\Wechat;

use App\Service\System\ConfigSv;
use App\Library\RedisClient;

/**
 * 微信服务类
 *
 * @author Meroc Chen <398515393@qq.com> 2018-03-08
 */
class WechatSv extends ConfigSv {

  protected $_appid;

  protected $_appsecret;

  public function __construct($type) {
  
    $this->_appid = $this->getConfig("{$type}_appid");

    $this->_appsecret = $this->getConfig("{$type}_appsecret");
  
  }

  /**
   * 获取微信访问令牌
   *
   * @return string accessToken
   */
  public function getAccessToken() {
  
  
  
  }

}
