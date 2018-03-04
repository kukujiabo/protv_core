<?php
namespace App\Service\Resource;

use App\Service\Crm\MemberSv;
use App\Service\BaseService;
use Core\Service\CurdSv;

/**
 * 图片资源服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-01-31
 */
class ImageSv extends BaseService {

  use CurdSv;

  public function addImageResource($imgId, $url, $module, $relatId = '', $base64 = '') {

    $newImg = array(
    
      'img_id' => $imgId,

      'url' => $url,

      'module' => $module,

      'relat_id' => $relatId,

      'base64' => $base64,

      'created_at' => date('Y-m-d H:i:s')
    
    );
  
    $imgId = $this->add($newImg);
  
    switch($module) {
    
      case 1:

        $this->updateMemberPortrait($relatId, $url);

      break;
    
      case 2:

      break;
    
    }
    
    return $imgId;
  
  }

  /**
   * 更新用户头像信息
   *
   * @param int $id
   * @param string $url
   *
   * @return
   */
  public function updateMemberPortrait($id, $url) {
  
    $msv = new MemberSv();

    $msv->editMember($id, array('portrait' => $url));
  
  }

}
