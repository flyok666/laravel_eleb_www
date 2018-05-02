<?php

namespace App\Http\Controllers;

use App\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //注册
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'=>'required|unique:members',
            'password'=>'required',
            'tel'=>'required|unique:members',
            'sms'=>'required',
        ]);

        //验证失败
        if ($validator->fails()) {
            //获取验证错误信息
            $errors = $validator->errors();
            //echo $errors->first('email');
            return ['status'=>'false','message'=>$errors->first()];
        }
        //验证短信
        $code = Redis::get('code_'.$request->tel);
        if($code && $code == $request->sms){
            $user = new Member();
            $user->fill($request->input());
            $user->password = bcrypt($request->password);
            $user->status = 1;
            $user->save();
            return ['status'=>'true','message'=>'注册成功'];
        }else{
            return ['status'=>'false','message'=>'手机验证码不正确'];
        }

    }

    //登录
    public function login(Request $request)
    {
        if(Auth::attempt(['username'=>$request->name,'password'=>$request->password],true)){
            $user = Auth::user();
            return [
                "status"=>'true',
                "message"=>"登录成功",
                "user_id"=>$user->id,
                "username"=>$user->username
            ];
        }else{
            return [
                "status"=>'false',
                "message"=>"登录失败,用户名或密码错误",
            ];
        }
    }

    public function logout()
    {
        Auth::logout();
    }

    //验证码
    public function sms(Request $request)
    {
        $tel = $request->tel;
        $code = rand(1000,9999);

        /*$params = array ();

        // *** 需用户填写部分 ***

        // fixme 必填: 请参阅 https://ak-console.aliyun.com/ 取得您的AK信息
        $accessKeyId = "LTAIHSWP3kfhwH1v";
        $accessKeySecret = "Wtz8R9ZqLnsXj2j180FqpimSGLojLc";

        // fixme 必填: 短信接收号码
        $params["PhoneNumbers"] = $tel;

        // fixme 必填: 短信签名，应严格按"签名名称"填写，请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/sign
        $params["SignName"] = "陈哥小店";

        // fixme 必填: 短信模板Code，应严格按"模板CODE"填写, 请参考: https://dysms.console.aliyun.com/dysms.htm#/develop/template
        $params["TemplateCode"] = "SMS_133780003";

        // fixme 可选: 设置模板参数, 假如模板中存在变量需要替换则为必填项
        $params['TemplateParam'] = Array (
            "code" => mt_rand(100000,999999),
            //"product" => "阿里通信"
        );

        // fixme 可选: 设置发送短信流水号
        //$params['OutId'] = "12345";

        // fixme 可选: 上行短信扩展码, 扩展码字段控制在7位或以下，无特殊需求用户请忽略此字段
        //$params['SmsUpExtendCode'] = "1234567";


        // *** 需用户填写部分结束, 以下代码若无必要无需更改 ***
        if(!empty($params["TemplateParam"]) && is_array($params["TemplateParam"])) {
            $params["TemplateParam"] = json_encode($params["TemplateParam"], JSON_UNESCAPED_UNICODE);
        }

        // 初始化SignatureHelper实例用于设置参数，签名以及发送请求
        $helper = new \App\Sms();

        // 此处可能会抛出异常，注意catch
        $content = $helper->request(
            $accessKeyId,
            $accessKeySecret,
            "dysmsapi.aliyuncs.com",
            array_merge($params, array(
                "RegionId" => "cn-hangzhou",
                "Action" => "SendSms",
                "Version" => "2017-05-25",
            ))
        // fixme 选填: 启用https
        // ,true
        );*/

        //dd($content);//短信发送结果
        //同一个手机号码,一分钟只能发送一条短信,一个小时只能发送5条,每天10
        if('OK' == 'OK'){
            //发送成功
            //保存到redis
            Redis::setex('code_'.$tel,5*60,$code);
            //$redis = new \Redis();
            //$redis->connect();
            //$redis->set()
            echo '{
      "status": "true",
      "message": "获取短信验证码成功",
      "code": '.$code.',
    }';
        }else{
            //发送失败
            echo '{
      "status": "false",
      "message": "短信发送失败,请稍后再试"
    }';
        }
    }

    public function user()
    {
        return [Auth::user()];
    }
}
