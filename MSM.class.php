<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
use Common\Common\PHPMailer;
// include_once("../Common/CCPRestSDK.php");
class IndexController extends Controller {
    public function index(){
        $tmplData['title']='首页';
        $this->assign($tmplData);
        $this->display(); 
    }
    
    
    
    public function sendSMS(){
        $to = '15620828924';
        $datas = array('3456','123');
        $tempId = 1;
        $re=$this->sendTemplateSMS($to,$datas,$tempId);
    }
    
    
    
    /*
     * 发送短信验证码
     */
    //$to,$datas,$tempId
    public function sendTemplateSMS()
    {
        
        $to = I('param.to');
        $datas = I('param.datas');
        $tempId = I('param.tempId');
        //主帐号,对应开官网发者主账号下的 ACCOUNT SID
        $accountSid= '8a216da85f008800015f244b233e0d4e';
       
        //主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
        $accountToken= '763419a5e32d40a59241634655d75f15';
         
        //应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
        //在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
        $appId='8a216da85f008800015f244b238b0d54';
         
        //请求地址
        //沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
        //生产环境（用户应用上线使用）：app.cloopen.com
        $serverIP='sandboxapp.cloopen.com';
         
         
        //请求端口，生产环境和沙盒环境一致
        $serverPort='8883';
         
        //REST版本号，在官网文档REST介绍中获得。
        $softVersion='2013-12-26';
        // 初始化REST SDK
        $rest = new \Common\Common\REST($serverIP,$serverPort,$softVersion);
        
        $rest->setAccount($accountSid,$accountToken);
        $rest->setAppId($appId);
        
        // 发送模板短信
        // echo "Sending TemplateSMS to $to <br/>";
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
              echo "result error!";
            break;
        }
        if($result->statusCode!=0) {
            echo json_encode(array('code'=>0,'meg'=>'短信发送失败'));
            //   echo "error code :" . $result->statusCode . "<br>";
            //   echo "error msg :" . $result->statusMsg . "<br>";
            //TODO 添加错误处理逻辑
        }else{
            //  echo "Sendind TemplateSMS success!<br/>";
            // 获取返回信息
//             $smsmessage = $result->TemplateSMS;
//             return $smsmessage;
            echo json_encode(array('code'=>1,'meg'=>'短信发送成功'));
            // echo "dateCreated:".$smsmessage->dateCreated."<br/>";
            //  echo "smsMessageSid:".$smsmessage->smsMessageSid."<br/>";
            //TODO 添加成功处理逻辑
        }
    }
    
    
    public function send(){
        $email = '15620828924@163.com';
//         dump($this->sendemail($email));die();
        $re=$this->sendemail($email);
    }
    
    /*
     * 测试用户名和邮箱是否对应
     */
    public function sendemail(){
        $email = I('param.email');
//         echo $email;die();
        if($email){
//             dump(1);die();
//             $email=I('param.email');
            $code=rand(100000,999999);//生成一个6位随机数作为邮箱验证码
            session('code',$code);
            session('email',$email);
            $mail = new PHPMailer(); //建立邮件发送类
            $address =$email;
//             $address ='1018832466@qq.com';
            $mail->IsSMTP(); // 使用SMTP方式发送
            $mail->Host = "smtp.163.com"; // 您的企业邮局域名
            $mail->SMTPAuth = true; // 启用SMTP验证功能
            $mail->Username = "15620828924@163.com"; // 邮局用户名(请填写完整的email地址)
            $mail->Password = "liuxizhao123"; // 邮局密码
//             var_dump($mail->Port);die;
            $mail->Port=25;
            $mail->From = "15620828924@163.com"; //邮件发送者email地址
            $mail->FromName = "AI平台";
            $mail->AddAddress("$address","test");//收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
            //$mail->AddReplyTo("", "");
            	
            //$mail->AddAttachment("/var/tmp/file.tar.gz"); // 添加附件
            //$mail->IsHTML(true); // set email format to HTML //是否使用HTML格式
            	
            $mail->Subject = "找回密码验证码"; //邮件标题
            $mail->Body = "Hello,您的验证码是：{$code}"; //邮件内容
            $mail->AltBody = "This is the body in plain text for non-HTML mail clients"; //附加信息，可以省略
//             	dump($mail->Send());die();
            if($mail->Send()){
//                 dump(111);die();
//                 $smsmessage = $this->send;
//                 $res = json_encode('邮件已发送请注意查收');
//                 $res = '邮件已发送请注意查收';
                $data = array('code'=>'1','msg'=>'邮件发送成功');
                echo json_encode($data);
//                 dump($res);
//                 return $res;
//                 $this->ajaxReturn('邮件已发送请注意查收') ;
            }
        }else{
                $data = array('code'=>'0','msg'=>'邮件发送失败');
                echo json_encode($data);
//             dump(222);die();
//             $this->ajaxReturn(0) ;
//             $smsmessage = $this->send;
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
}