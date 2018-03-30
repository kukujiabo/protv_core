<?php
namespace App\Service\CMS;

use App\Service\BaseService;
use Core\Service\CurdSv;

class VideoFavoriteSv extends BaseService {

  use CurdSv;

  /**
   * 添加用户喜欢的视频
   *
   * @param int uid
   * @param int videoId
   *
   * @return int
   */
  public function addUserFavorVideo($uid, $videoId) {
  
    $newFavorite = [
    
      'member_id' => $uid,

      'video_id' => $videoId,

      'active' => 1,

      'created_at' => date('Y-m-d H:i:s')
    
    ];
  
    return $this->add($newFavorite);
  
  }

  /**
   * 取消用户喜欢的视频
   *
   * @param int uid
   * @param int videoId
   *
   * @return int
   */
  public function cancelUserFavorVideo($uid, $videoId) {
  
    $favor = $this->findOne([ 
      
      'member_id' => $uid, 
      
      'video_id' => $videoId,
    
      'active' => 1
    
    ]); 

    if ($favor) {
    
      return $this->update($favor['id'], [ 'active' => 0 ]);
    
    } else {
    
      return 0;
    
    }
  
  }


}
