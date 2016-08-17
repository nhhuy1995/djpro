<?php
$config = include "../../../app/config/config.php";
include "../../../app/config/development.config.php";

function RemoveSign($str)
{
    $coDau = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", "ê", "ù", "à");

    $khongDau = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "e", "u", "a");
    return str_replace($coDau, $khongDau, $str);
}

function removeTitle($string, $keyReplace = '-')
{
    $string = RemoveSign($string);
    //neu muon de co dau
    $string = trim(preg_replace("/[^A-Za-z0-9.]/i", " ", $string)); // khong dau
    $string = str_replace(" ", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace("--", "-", $string);
    $string = str_replace($keyReplace, "-", $string);
    $string = strtolower($string);
    return $string;
}

try {
    $data['status'] = 200;
    $targetFolder = $config->upload->dir . "uploads/" . date("Y/m/d");
    $tempFile = $_FILES['Filedata']['tmp_name'];
    $fileParts = pathinfo($_FILES['Filedata']['name']);
    $folder_name = '/';
    $is_image = false;
    /*if($_POST['create_folder_type'] == 'true'){*/
    $folder_name = '/general/';
    if (in_array($fileParts['extension'], array('jpg', 'jpeg', 'gif', 'png'))) {
        $is_image = true;
        $folder_name = '/picture/';
    }
    if (in_array($fileParts['extension'], array('mp3', 'mp4', 'avi', 'mkv'))) {
        $folder_name = '/video/';
    }
    if (in_array($fileParts['extension'], array('apk', 'ipa'))) {
        $folder_name = '/game/';
    }
    /*}*/
//$targetPath = getcwd() . $targetFolder . $folder_name;
//    $rename =
    $targetPath = str_replace("../", "", $targetFolder . $folder_name);
    if (!file_exists($targetPath)) mkdir($targetPath, 0777, true);
    $file_name = removeTitle($_FILES['Filedata']['name']);
    $file_name = str_replace(" ", "_", strtotime("now") . "_" . $file_name);
    $targetFile = str_replace("//", "/", $targetPath) . $file_name;
    $dimensions = array();
    if ($is_image) {
//        require_once("../phpthumb/PhpThumbFactory.php");
//        $thumb = PhpThumbFactory::create($tempFile);
//        list($width, $height, $type, $attr) = @getimagesize($tempFile);
//        $max_size = !empty($_POST['max_size']) ? intval($_POST['max_size']) : 650;
//        if($width > $max_size){
//            $thumb->resize($max_size);
//            $dimensions = $thumb->getNewDimensions();
//        }else{
//            $dimensions = array('newWidth'=>$width,'newHeight'=>$height);
//        }
//        $rs = $thumb->save($targetFile);
    } else {
        $rs = move_uploaded_file($tempFile, $targetFile);
        $TextEncoding = "UTF-8";
        $id3LibPath = "../../../app/library/getid3/";
        require_once($id3LibPath . "getid3.php");
        require_once($id3LibPath . "write.php");
        $getID3 = new \getID3();
        $getID3->setOption(array('encoding' => $TextEncoding));
        $tagwriter = new getid3_writetags();
        $tagwriter->filename = $targetFile;
        $tagwriter->tagformats = array('id3v2.3');
// set various options (optional)
        $tagwriter->overwrite_tags = true;
        $tagwriter->tag_encoding = $TextEncoding;
        $tagwriter->remove_other_tags = true;

// populate data array
        $siteName = "www.Dj.pro.vn";
        $TagData = array(
            'title' => array($file_name . " [" . $siteName . " ]"),
            'artist' => array($siteName),
            'album' => array($siteName),
            'year' => array(date("Y")),
            'genre' => array($siteName),
            'copyright' => array($siteName)
        );
        $tagwriter->tag_data = $TagData;
        $tagwriter->WriteTags();
    }

    if ($rs) {
        $file_path = $targetFolder . $folder_name . $file_name;
        $file_path = str_replace($config->upload->dir, "/web/", $file_path);
        $image = $file_path;
        $data['status'] = 200;
        $data['mss'] = "Upload thành công";
        $data['file'] = array(
            "index" => (string)strtotime("now") . rand(0, 99999),
            "filename" => "$file_name", "src" => "$file_path",
            "path" => "$file_path", "image" => "$image",
            "type" => "$type"
        );
        if ($is_image) {
            $data['size'] = $dimensions;
        }
    } else {
        $data['status'] = 500;
        $data['mss'] = "Không thể upload file: $tempFile";
        $data['tgpath'] = $targetPath;
        $data['exsist'] = $checkExist;
        $data['mkdirRes'] = $mkdirResult;
        $data['acc'] = array(posix_getpwuid(posix_geteuid()));
    }
    echo json_encode($data);
} catch (Exception $e) {
    $data['status'] = 500;
    $data['mss'] = $tagwriter->errors;
    echo json_encode($data);
}
?>