<?php
namespace App\Domain;

use App\Service\Components\Wechat\WechatSv;

class WechatDm {

  protected $_wxsv;

  public function __construct() {
  
    $this->_wxsv = new WechatSv();
  
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

}
