<?php
namespace DjClient\Controller;

use DjClient\Services\Email;

class TestController extends ControllerBase
{
    public function indexAction()
    {
        $chars = array('nghedi.tk','.tk','"','< "','" >','<"','">','.vn','`','nghedi','NGHEDI','NgheDi','tk','Tk','TK','.TK','http','www','lin','lìn','htt','ww','Refresh','địt','Địt','ĐỊT','đéo','Đéo','ĐÉO','lồn','Lồn','LỒN','L0N','L0n','l0n','lôn','lon`','llon','lô`n','lo`n','cặc','Cặc','CẶC','dái','Dái','DÁI','chó','Chó','CHÓ','Cứt','cứt','CỨT','ỉa','Ỉa','đái','Đái','ỈA','.com','.org','.biz','dkm','đkm','ĐKM','dit','lon','Lon','lyn','LON','DIT','D J . K e n h 7 4 . C o m','. C o m','DIT','cut','Cut','tom9z','369','4444','888','DM','loz','djt','đjt','bán','sim','sjm','T O P D J V N . C o m','T O P D J V N','09', 'con mẹ' , 'mẹ mày');

        $data = implode($chars,',');
//        echo $data;die(123);
    }

    public function mailAction() {
    	Email::sendtestAction();die;
    	// echo !extension_loaded('openssl')?"Not Available":"Available";die;
    	$email = 'lenhamhung.pfiev@gmail.com';
    	$subject = "Lấy lại mật khẩu Dj.pro.vn";
        $content = "<a href='http://dj.pro.vn/khoi-phuc-mat-khau.html?token=$token_key'>Click vào đây để lấy lại mật khẩu.</a>";
        Email::sendMail($subject, $email, $content);
        echo 'Success';die;
    }

}

