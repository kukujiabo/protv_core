<?php
namespace App\Domain;

use App\Service\Components\Wechat\WechatAppSv;

class WechatDm {

  protected $_wxsv;

  public function __construct() {
  
    $this->_wxsv = new WechatAppSv();
  
  }

  /**
   * 编辑微信应用配置
   */
  public function editAppConf($appName, $appid, $appsecret, $title) {
  
    return $this->_wxsv->editAppConf($appName, $appid, $appsecret, $title); 

  }

  /**
   * 读取微信访问令牌
   */
  public function getAccessToken() {
  
    return $this->_wxsv->getAccessToken();
  
  }

  /**
   * 获取openID
   */
  public function getOpenId($openId) {
  
    return $this->_wxsv->getOpenId($openId);
  
  }

}
