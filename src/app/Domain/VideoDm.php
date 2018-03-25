<?php
namespace App\Domain;

use App\Service\CMS\VideoSv;

/**
 * 视频服务域
 *
 * @author Meroc Chen <398515393@qq.com> 2018-02-12
 */
class VideoDm {

  protected $_vsv;

  public function __construct() {
  
    $this->_vsv = new VideoSv();
  
  }

  /**
   * 添加视频
   *
   * @param int outId
   * @param int memberId
   * @param int categoryId
   * @param int albumId
   * @param int title
   * @param int brief
   * @param int url
   *
   * @return 
   */
  public function addVideo($outId, $authorId, $memberId, $categoryId, $cover, $albumId, $title, $brief, $introduction, $url, $status, $duration) {
  
    return $this->_vsv->addVideo($outId, $authorId, $memberId, $categoryId, $cover, $albumId, $title, $brief, $introduction, $url, $status, $duration);
  
  }

  /**
   * 编辑视频信息
   *
   * @param int id
   * @param array videoInfo
   * @param int videoInfo.category_id
   * @param int videoInfo.album_id
   * @param string videoInfo.title
   * @param string videoInfo.brief
   * @param string videoInfo.cover
   * @param int videoInfo.status
   *
   * @return boolean true/false
   */
  public function editVideo($id, $outId, $categoryId, $albumId, $cover, $title, $brief, $introduction, $url, $status, $duration) {

    $data = [];

    if (isset($outId)) $data['out_id'] = $outId;
    if (isset($categoryId)) $data['category_id'] = $categoryId;
    if (isset($albumId)) $data['album_id'] = $albumId;
    if (isset($cover)) $data['cover'] = $cover;
    if (isset($title)) $data['title'] = $title;
    if (isset($brief)) $data['brief'] = $brief;
    if (isset($introduction)) $data['brief'] = $introduction;
    if (isset($url)) $data['url'] = $url;
    if (isset($status)) $data['status'] = $status;
    if (isset($duration)) $data['duration'] = $duration;

    return $this->_vsv->editVideo($id, $data);
  
  }

  /**
   * 查询视频列表
   *
   * @param string outId
   * @param int memberId
   * @param int categoryId
   * @param int albumId
   * @param string keyword
   * @param int status
   * @param string order
   * @param int page
   * @param int pageSize
   *
   * @return
   */
  public function listQuery($outId, $memberId, $categoryId, $albumId, $keyword, $status, $order, $all, $page, $pageSize) {
  
    return $this->_vsv->listQuery($outId, $memberId, $categoryId, $albumId, $keyword, $status, $order, $all, $page, $pageSize); 
  
  }

  /**
   * 查询视频详情
   *
   * @param int id
   *
   * @return array 
   */
  public function detail($id) {
  
    return $this->_vsv->findOne($id);
  
  }

  /**
   * 删除视频
   *
   * @param int id
   *
   * @return int num
   */
  public function remove($id) {
  
    return $this->_vsv->remove($id);
  
  }

}
