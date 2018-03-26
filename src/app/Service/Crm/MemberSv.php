<?php
namespace App\Service\Crm;

use App\Service\BaseService;
use App\Common\Traits\AuthTrait;
use App\Exception\LogException;
use App\Exception\ErrorCode;
use Core\Service\CurdSv;
use App\Library\RedisClient;
use App\Service\Components\Wechat\WechatAppSv;

/**
 * 会员服务类
 *
 * @author Meroc Chen <398515393@qq.com>
 */
class MemberSv extends BaseService {

  use AuthTrait;

  use CurdSv;

  protected $_acctName = 'mobile';

  protected $_secret = 'password';

  protected $_auth = 'auth_token';

  /**
   * 用户账号直接登录（需前置校验通过）
   *
   * @param string $account
   * @param string $password
   *
   * @return 
   */
  public function loginViaAccount($account) {
  
    $auth = $this->findOne(array($this->_acctName => $account));

    if (!$auth) {

      /**
       * 账号不存在
       */
    
      throw new LogException($this->_err->AEPTMSG, $this->_err->AEPTCODE);
    
    }

    return $this->createSession($auth['id'], 'member_auth'); 

  }

  /**
   * 用户账号密码登录
   *
   * @param string $account
   * @param string $password
   *
   * @return 
   */
  public function loginViaPassword($account, $password) {

    /**
     * 校验账号密码
     */
    $auth = $this->acctCheck($account, $password);
  
    if ($auth) {

      /**
       * 校验通过
       */
      $member = $this->findOne(array($this->_acctName => $account));

      return $this->createSession($member['id'], 'member_auth');

    } elseif ($auth === FALSE) {

      /**
       * 账号密码错误
       */
    
      throw new LogException($this->_err->APMISMSG, $this->_err->APMISCODE);
    
    } elseif ($auth === NULL) {

      /**
       * 账号不存在
       */
    
      throw new LogException($this->_err->AEPTMSG, $this->_err->AEPTCODE);
    
    }
  
  }

  /**
   * 微信小程序登录
   *
   * @param string $code
   *
   * @return
   */
  public function wxMiniLogin($code) {
  
    
  
  }

  /**
   * 用户注册
   *
   * @param string $account
   * @param string $password
   *
   * @return
   */
  public function register($account, $password = null) {

    if (empty($account)) {

      throw new LogException($this->_err->RGEPTACCTMSG, $this->_err->RGEPTACCTCODE);
    
    }
  
    return $this->createAuth($account, $password);
  
  }

  /**
   * 编辑用户信息
   *
   * @param int $id
   * @param array $data
   *
   * @return boolean true/false
   */
  public function editMember($id, $data) {

    if ($this->update($id, $data)) {

      $member = $this->findOne($id);

      if ($member[$this->_auth]) {
      
        RedisClient::set('member_auth', $member[$this->_auth], $member);

      }

      return true;

    } else {
    
      return false;
    
    }
  
  }

  /**
   * 修改密码
   *
   * @param string $oldPassword
   * @param string $newPassword
   *
   * @return boolean true/false
   */
  public function updatePassword($memberId, $oldPassword, $newPassword) {

    $member = $this->findOne($memberId);

    if (!$member[$this->_secret]) {

      /**
       * 用户第一次设置密码
       */

      return $this->editSecret($member[$this->_acctName], $newPassword);
    
    } else {

      /**
       * 用户修改密码
       */
      if ($this->acctCheck($member[$this->_acctName], $oldPassword)) {
      
        return $this->editSecret($member[$this->_acctName], $newPassword);
      
      } else {

        /**
         * 旧密码输入错误，抛出异常
         */
      
        throw new LogException($this->_err->WOLDPASSMSG, $this->_err->WOLDPASSCODE);
      
      }
    
    }
  
  }

  /**
   * 判断账户名是否存在
   *
   * @param string $account
   *
   * @return boolean true/false
   */
  public function existAccount($account) {
  
    if ($this->findOne(array($this->_acctName => $account))) {
    
      return true;
    
    } else {
    
      return false;
    
    }
  
  }

  /**
   * 微信小程序登录
   * @desc 微信小程序登录
   *
   * @param string appName
   * @param string code
   *
   * @return 
   */
  public function wechatMiniLogin($appName, $code) {
  
    $wxApp = new WechatAppSv($appName);

    $wxInfo = $wxApp->getOpenId($code);

    $auth = $this->findOne([ 'wx_mnopenid' => $wxInfo->openId ]);

    if ($auth) {
    
      return $this->createSession($auth['id'], 'member_auth'); 
    
    } else {
    
      $result = $this->createAuthByWxMiniOpenId($wxInfo->openId, $wxInfo->unionid);

      if ($result) {
      
        return $this->createSession($result, 'member_auth');
      
      }
    
    }
  
  }

}
