<?php
namespace DjCms\Controller;

/**
 * Class ImagecropController
 */
class ImagecropController extends ControllerBase
{
    protected $ownActionIgnoreCheckPermission = array(
        "imagecrop_view"
    );

    /**
     * Controller process image
     */
    public function indexAction()
    {
        error_reporting(E_ALL);
        if (!isset($_POST['crop_img'])) return $this->jsonResponse(array('error' => 'invalid image #1'));

        // get data
        if (strpos($_POST['crop_img'], 'data:') !== false) {
            // save image to disk
            $img_path = $this->base64_to_image($_POST['crop_img']);
        } elseif (strpos($_POST['crop_img'], get_host()) !== false) {
            // get image from disk
            $img_path = str_replace(get_host(), null, $_POST['crop_img']);
        } else {
            die('wtf');
        }

        $size = getimagesize($img_path);
        $img_r = null;
        
        switch ($size['mime']) {
            case 'image/png':
                $img_r = imagecreatefrompng($img_path);
                break;
            case 'image/jpg':
            case 'image/jpeg':
                $img_r = imagecreatefromjpeg($img_path);
                break;
            case 'image/bmp':
                $img_r = imagecreatefromwbmp($img_path);
                break;
            case 'image/gif':
                $img_r = imagecreatefromgif($img_path);
                break;
            default:
                return $this->jsonResponse(array('error' => 'invalid image #2'));
        }

        $aspectRatio = $this->request->get('aspect_ratio');
        if (empty($aspect_ratio)) {
            $type = $this->request->get("type");
            $aspectRatio = (array) json_decode($aspectRatio);
        } else
            $aspectRatio = (array) json_decode($aspectRatio);
        $dst_r = imagecreatetruecolor($_POST['w'], $_POST['h']);
        imagecopyresampled($dst_r, $img_r, 0, 0, $_POST['x'], $_POST['y'], $_POST['w'], $_POST['h'], $_POST['w'], $_POST['h']);
        $img_r = imagecreatetruecolor($aspectRatio['width'], $aspectRatio['height']);
        imagecopyresized($img_r, $dst_r, 0, 0, 0, 0, $aspectRatio['width'], $aspectRatio['height'], $_POST['w'], $_POST['h']);

        $img_path = explode('.', $img_path);
        $img_path[count($img_path) - 1] = sprintf('-%s-%s-%s.%s', $aspectRatio['width'], $aspectRatio['height'], md5(time()), $img_path[count($img_path) - 1]);
        $img_path = implode('', $img_path);

        if (imagejpeg($img_r, $img_path, 100)) {
            if (function_exists('get_client_static_dir')) {
                $img_path = str_replace($this->config->upload->dir, get_client_static_dir(), $img_path);
            }
            return $this->jsonResponse(array('image' => $img_path));
        }
    }

    /**
     * @param $base64_string
     * @return string
     */
    function base64_to_image($base64_string)
    {
        $uploaddir = $this->config->upload->dir;
        $allow = (array)$this->config->upload->extension;
        $folder = "uploads/" . date("Y/m/d/");
        if (!file_exists($uploaddir . $folder)) mkdir($uploaddir . $folder, 0777, true);

        $data = explode(',', $base64_string);
        $img_content = $data[1];
        $img_name = md5(mb_substr($data[1], 0, 10)) . '.jpg';
        $filename = $uploaddir . $folder . $img_name;

        $ifp = fopen($filename, "wb");
        fwrite($ifp, base64_decode($img_content));
        fclose($ifp);

        return $filename;
    }

    protected function getAspectRation($type)
    {
        if ($type == "news")
            return array("width" => 275, "height" => 275);
        if ($type == "banner")
            return array("width" => 2300, "height" => 800);
        return array("width" => 480, "height" => 360);
    }
}