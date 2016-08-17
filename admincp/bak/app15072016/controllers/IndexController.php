<?php
namespace DjCms\Controller;
use DjCms\Models\Album;
use DjCms\Models\Media;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
//        $listAlbum = Album::findAndReturnArray();
//        $listMedia = Media::findAndReturnArray(array(
//           "type" => "audio"
//        ));
//
//        foreach ($listMedia as $media) {
//            $mediaIds[] = $media['_id'];
//        }
//        $countMediaIds = count($mediaIds) - 8;
//        foreach ($listAlbum as $album) {
//            $rand = rand(3, $countMediaIds);
//            $listIndex = array_rand($mediaIds, $rand);
//            foreach($listIndex as $key) {
//                $listIds[] = $mediaIds[$key];
//            }
//            Album::updateDocument(
//                array("_id" => $album['_id']),
//                array('$set' => array(
//                   "listsong" => $listIds
//                ))
//            );
//            unset($listIds);
//        }
//        die;
    }

}

