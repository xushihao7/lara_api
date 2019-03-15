<?php
   namespace App\Http\Controllers\User;
   use App\Http\Controllers\Controller;
   use Illuminate\Http\Request;
   use Illuminate\Support\Facades\Redis;
   class IndexController extends Controller{
       public  $hash_token="h:login:token:";
       //用户登录
       public  function  login(Request $request){
           $uid=$request->input("uid");
           //设置token
           $token=substr(md5(time()+$uid+rand(1000,9999)),10,20);
           if(1){
               $key=$this->hash_token.$uid;
               Redis::hSet($key,'token',$token);
               Redis::expire($key,60*60*24*7);
               $response=[
                   'error'=>0,
                   'msg'=>'ok'
               ];
           }else{
               //TODO
           }

           return $response;
       }
       //用户中心
       public  function  userCenter(Request $request){
             $uid=$request->input('uid');
             //print_r($_SERVER);die;
             if(!empty($_SERVER['HTTP_TOKEN'])){
                 $http_token=$_SERVER['HTTP_TOKEN'];
                 $key=$this->hash_token.$uid;
                 $token=Redis::hGet($key,'token');
                 if($http_token==$token){
                     $response=[
                         'error'=>0,
                         'msg'=>'ok'
                     ];
                 }else{
                     $response=[
                         'error'=>5001,
                         'msg'=>'invalid token'
                     ];
                 }


             }else{
                 $response=[
                     'error'=>5000,
                     'msg'=>'not find token'
                 ];

             }
          return $response;




      }
       //防止非法请求
       public  function  order(){
           //print_r($_SERVER);
           $request_url=$_SERVER['REQUEST_URI'];
           $ip=$_SERVER['SERVER_ADDR'];
           $request_url=substr(md5($request_url),0,10);
           $redis_key='str:'.$request_url.":".$ip;
           echo $redis_key;
           $num=Redis::incr($redis_key);
           Redis::expire($redis_key,60);
           echo $num;
           if($num>20){

               //停止服务10分钟
                 $response=[
                     'error'=>4003,
                     'msg'=>'invaild request'
                 ];
                Redis::expire($redis_key,600);


           }else{
               $response=[
                   'error'=>0,
                   'msg'=>'ok'
               ];
           }
           return $response;
       }



   }