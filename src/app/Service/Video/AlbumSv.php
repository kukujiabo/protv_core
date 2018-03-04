<?php
namespace App\Service\Video;
use App\Model\Member;
use App\Model\Author;
use Core\Service\CurdSv;
use App\Service\BaseService;
use App\Service\Crm\MemberSv;
use App\Service\Admin\AdminSv;
use App\Exception\LogException;

/**
 * 专辑服务
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-05
 */
class AlbumSv extends BaseService {

  use CurdSv;

  /**
   * 添加专辑
   *
   * @param int $memberId
   * @param int $title
   * @param int $brief
   * @param int $cover
   *
   * @return int $id
   */
  public function addAlbum($authorId, $memberId, $title, $brief, $cover, $introduction, $status) {

    $newAlbum = [
    
      'author_id' => $authorId,

      'member_id' => $memberId,

      'title' => $title,

      'brief' => $brief,

      'cover' => $cover,

      'introduction' => $introduction,

      'status' => $status,

      'created_at' => date('Y-m-d H:i:s')
    
    ];

    return $this->add($newAlbum);
  
  }

  /**
   * 编辑专辑信息
   *
   * @param int title
   * @param int brief
   * @param int cover
   * @param int status
   *
   * @return array $data
   */
  public function editAlbum($id, $data) {

    $album = $this->findOne($id);

    if (!$album) {
    
      throw new LogException($this->_err->ABNOTFOUNDMSG, $this->_err->ABNOTFOUNDCODE);
    
    }
  
    return $this->update($id, $data);
  
  }

  /**
   * 查询列表
   *
   * @param array query
   * @param int query.memberId
   * @param int query.keyword
   * @param int query.state
   * @param int all
   * @param int page
   * @param int pageSize
   * @param string fields
   *
   * @return array $data
   */
  public function listQuery($query, $order, $all = 0, $page = 1, $pageSize = 20, $fields = '*') {
  
    $options = [];
    $albums = [];
    $members = [];
    $admins = [];

    if ($all) {

      $albums = $this->all($options, $order);
    
    } else {
    
      $albums = $this->queryList($query, $fields, $order, $page, $pageSize);
    
    }

    foreach ($albums['list'] as $album) {

      if ($album['author_id']) {

        if (!in_array($album['member_id'], $members)) {
      
          array_push($members, $album['member_id']);

        }
      
      } else {

        if (!in_array($album['member_id'], $admins)) {

          array_push($admins, $album['member_id']);

        }

      }
    
    }

    if (!empty($members)) {
    
      $memberCondition = [
        
        'id' => implode(',', $members)

      ];

      $memberSv = new MemberSv();

      $memberInfo = $memberSv->all($memberCondition);

      foreach($albums['list'] as $key => $album) {

        foreach($memberInfo as $info) {
      
          if ($album['member_id'] && $album['member_id'] == $info['id']) {
        
            $albums['list'][$key]['author'] = $info['member_name'];
          
          }

        }
      
      }
    
    }

    if (!empty($admins)) {
    
      $adminCondition = [
      
        'id' => implode(',', $admins)

      ];
    
      $adminSv = new AdminSv();

      $adminInfo = $adminSv->all($adminCondition);
      
      foreach($albums['list'] as $key => $album) {
      
        foreach($adminInfo as $info) {

          if (!$album['author_id'] && $album['member_id'] == $info['id']) {

            $albums['list'][$key]['author'] = $info['admin_name'];

          }
        
        } 
      
      }
    
    }

    return $albums;
  
  }


}
